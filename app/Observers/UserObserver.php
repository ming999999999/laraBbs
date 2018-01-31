<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Topic;
use App\Models\Reply;


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;



// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function creating(User $user)
    {
        //
    }

    public function updating(User $user)
    {
        //
    }

    public function deleting(User $user)
    {

    	$this->up();
    	$this->down();
    }

    public function up()
    {

    	Schema::table('topics',function(Blueprint $table)
    	{
    		$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    	});

    	Schema::table('replies',function(Blueprint $table)
    	{
    		$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


    		$table->foreign('topic_id')->references('id')->on('users')->onDelete('cascade');
    	});
    }

    public function down()
    {
    	Schema::table('topics',function(Blueprint $table)
    	{
    		$table->dropForeign(['user_id']);
    	});

    	Schema::table('replies',function(Blueprint $table)
    	{
    		$table->dropForeign(['user_id']);
    		$table->dropForeign(['topic_id']);
    	});
    }
}