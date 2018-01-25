<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;

use App\Notifications\TopicReplied;
use Auth;
use App\Models\Topic;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	
	public function store(ReplyRequest $request,Reply $reply,Topic $topic)
	{
		
		$reply->content = $request->content;
		$reply->user_id = Auth::id();
		$reply->topic_id = $request->topic_id;
		$reply->save();

		$topic = $reply->topic;

		$topic->increment('reply_count',1);

		// 如果评论者不是话题的作者,才需要通知
		if(!$reply->user->isAuthorOf($topic))
		{

			$topic->user->notify(new TopicReplied($reply));
		}

		return back()->with('success','创建成功!');
	}


	public function destroy(Reply $reply)
	{
		$this->authorize('destroy', $reply);
		$reply->delete();

		return redirect()->route('replies.index')->with('message', 'Deleted successfully.');
	}
}