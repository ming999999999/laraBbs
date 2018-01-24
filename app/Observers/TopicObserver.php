<?php

namespace App\Observers;

use App\Models\Topic;
use App\Models\SlugTranslateHandler;
use App\Jobs\TranslateSlug;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        
    }

    public function saving(Topic $topic)
    {   
        // 生成话题的摘录
    	// $topic->excerpt = make_excerpt($topic->body);

     //    // xss过滤
     //    $topic->body = clean($topic->body,'user_topic_body');

        // 如slug字段无内容,及时使用翻译器对title进行翻译
        // if(!$topic->slug)
        // {
        //     $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        // }

        // 如字段无内容,及时用翻译器对title进行翻译
        // if(! $topic->slug)
        // {
        //     // 推送任务到队列
        //     dispatch(new TranslateSlug($topic));
        // }
    }

    public function saved(Topic $topic)
    {

        // // 如字段无内容,及时用翻译器对title进行翻译
        // if(! $topic->slug)
        // {
        //     // 推送任务到队列
        //     dispatch(new TranslateSlug($topic));
        // }
    }
}