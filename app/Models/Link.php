<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Cache;

class Link extends Model
{
    protected $fillable = ['title','link'];

    protected $cache_key = 'larabbs_links';

    protected $cache_expire_in_minutes = 1440;

    public function getAllCached()
    {

    	// 尝试着从缓存中取出cache_key 对应的数据,如果可以取到,便直接返回数据.
    	// 否则运行匿名函数中的代码来取出活跃的用户的数据,返回的同时做了缓存
    	return Cache::remember($this->cache_key,$this->cache_expire_in_minutes,function(){

    		return $this->all();
    	});
    }

    // 在保持时清空cache_key 对应缓存
    public function cacheFlash()
    {
        Cache::forget($this->cache_key);

    }

    
    
}
