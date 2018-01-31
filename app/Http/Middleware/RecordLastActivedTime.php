<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RecordLastActivedTime
{
    /**
     * 
     *
     */
    public function handle($request, Closure $next)
    {

        // 如果是登录的用户的话
        if(Auth::check())
            {
                // 记录最后的登录的时间
                Auth::user()->recordLastActivedAt();
            }
        return $next($request);
    }
}
