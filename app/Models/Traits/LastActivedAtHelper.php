<?php

namespace App\Models\Traits;

use Redis;
use Carbon\Carbon;

	trait LastActivedAtHelper
	{

		// 缓存相关
		protected $hash_prefix = 'larabbs_last_actived_at_';
		protected $field_prefix = 'user_';

		public function recordLastActivedAt()
		{

			// Redis哈希表命名, 如:larabbs_last_actived_at_2017-10-21
			$hash = $this->getHashDateString(Carbon::now()->toDateString());

			// 字段的名称
			$field = $this->getHashField();

			// dd(Redis::hGetAll($hash));
			

			// 当前时间如:2017-10-21 08:35:22
			$now = Carbon::now()->toDateTimeString();

			// 数据写入Redis,字段已存在会别更新
			Redis::hset($hash,$field,$now);
		}

		public function syncUserActivedAt()
		{
			// 获取昨天的如期,格式如2017-01-01
			// $yestoday_date = Carbon::now()->subDay()->toDateString();
		
			// Redis哈希表的命名,
			$hash = $this->getHashDateString(Carbon::now()->subDay()->toDateString());

			// 从Redis中获取hash表中的数据
			$dates = Redis::hGetAll($hash); 

			// 便利并同步到数据库中
			foreach( $dates as $user_id =>$actived_at)
			{

				// 将user_1转换为1
				$user_id = str_replace($this->field_prefix,'',$user_id);

				// 只有当用户存在的时候才更新到数据库中
				if($user = $this->find($user_id))
				{
					$user->last_actived_at = $actived_at;
					$user->save();
				}
			}

			// 以数据库为中心的存储,既已同步,即可删除
			Redis::del($hash);
		}

		public function getLastActivedAtAttribute($value)
		{
			

			// reids hash表命名
			$hash = $this->getHashFromDateString(Carbon::now()->toDateString());

			// 字段名称
			$field = $this->getHashField();

			// 三元运算符优先选择redis的数据否则使用数据库中的数据
			$datetime = Redis::hGet($hash,$field) ? :$value;

			// 如果存在的话,返回时间对应的Carbon实体
			if($datetime)
			{
				return new Carbon($datetime);
			}else{
				// 否则返回注册时间
				return $this->created_at;
			}
		}

		public function getHashFromDateString($date)
		{
			// Redis哈希表的命名,
			return $this->hash_prefix.$date;
		}

		public function getHashField()
		{
			// 字段的名字
			return $this->field_prefix.$this->id;
		}


	}