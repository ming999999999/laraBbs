<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function show(Category $category, Request $request,Topic $topic)
    {
    		
    	// 读取分类id关联的话题,并按每页20条分页
    	$topic = $topic->withOrder($request->order)
    					->where('category_id',$category->id)
    					->paginate(20);

    	// 传参变量的话题和分类的模板中
    	return view('topics.index',compact('topics','category'));
    }
}