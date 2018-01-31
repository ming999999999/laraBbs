<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{

	public function created(Reply $reply)
	{

		// $topic = $reply->topic;

		// $topic->increment('reply_count',1);

		// // 如果评论者不是话题的作者,才需要通知
		// if(!$reply->user->isAuthorOf($topic))
		// {

		// 	$topic->increment('reply_count',1);
		// }
	}

    public function creating(Reply $reply)
    {
        //
    }

    public function updating(Reply $reply)
    {
        //
    }


}