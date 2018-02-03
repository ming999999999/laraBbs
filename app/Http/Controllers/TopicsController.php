<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use App\Handlers\ImageUploadHandler;
use Auth;

use App\Jobs\TranslateSlug;
use App\Models\SlugTranslateHandler;
use App\Models\User;
use App\Models\Link;
use Cache;



class TopicsController extends Controller
{

	// use \Traits\SmsHelper;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request,Topic $topic, User $user,Link $link)
	{


		$topics = $topic->withOrder($request->order)->paginate(20);

		$active_users = $user->getActiveUsers();

		$linkFlash = $link->cacheFlash();

		$links = $link->getAllCached();
		
		return view('topics.index', compact('topics','active_users','links'));
	}

    public function show(Topic $topic)
    {

        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{

		$categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request,Topic $topic)
	{
		

		$topic->fill($request->all());

		$topic->user_id = Auth::id();



		 //如字段无内容,及时用翻译器对title进行翻译
  			if(! $topic->slug)
  			{
  				// 推送任务到队列
  				dispatch(new TranslateSlug($topic));
  			}
		
		$topic->save();

		return redirect()->route('topics.show', $topic->id)->with('message', '创建成功');
	}

	public function edit(Topic $topic)
	{

        $this->authorize('update', $topic);

        $categories = Category::all();

		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', '修改成功');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		 $topic->delete();

		return redirect()->route('topics.index')->with('message', '删除成功');
	}

	public function uploadImage(Request $request,ImageUploadHandler $uploader)
	{

		$data = [
			'success'=>false,
			'msg'=>'上传失败',
			'file_path'=>''
		];

		// 判断是否有上传文件,并赋值给$file
		if($file = $request->upload_file)
		{

			// 保存图片到本地
			$result = $uploader->save($request->upload_file,'topics',\Auth::id(),1024);

			if($result)
			{
				$data['file_path'] = $result['path'];

				$data['msg'] = '上传成功';

				$data['success'] = true;
			}
		}

		return $data;
	}


}