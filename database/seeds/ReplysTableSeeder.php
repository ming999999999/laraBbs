<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {

    	// 所有用户id数组 
    	$user_ids = User::all()->pluck('id')->toArray();

    	// 所有话题id数组
    	$topic_ids = Topic::all()->pluck('id')->toArray();

    	// 获取Faker实例
    	$faker = app(Faker\Generator::class);


        // $replys = factory(Reply::class)->times(50)->make()->each(function ($reply, $index) {
        //     if ($index == 0) {
        //         // $reply->field = 'value';
        //     }
        // });

        $replys = factory(Reply::class)
        				->times(1000)
        				->make()
        				->each(function($reply,$index) use ($user_ids,$topic_ids,$faker)
        				{
        					// 从用户id数组中随机取出一个并赋值
        					$reply->user_id = $faker->randomElement($user_ids);

        					// 话题id同上
        					$reply->topic_id  = $faker->randomElement($topic_ids);
        				});
        				

        Reply::insert($replys->toArray());
    }

}

