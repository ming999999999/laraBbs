<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * 全局中间件,最先调用
     *
     */
    protected $middleware = [

        // 监测是否应用是否进入维护模式
        // 见：https://d.laravel-china.org/docs/5.5/configuration#maintenance-mode
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        
        // 监测请求的数据是否过大
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // 对于提交请求参数进行php函数trim()处理
        \App\Http\Middleware\TrimStrings::class,

        // 将提交请求的参数中的空字符串转换为null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

        // 修正代理服务器上后的服务器参数
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * 定义中间件组
     *
     */
    protected $middlewareGroups = [

        //web中间件组,应用于routes/web.php路由文件中 
        'web' => [

            // cookie加密解密
            \App\Http\Middleware\EncryptCookies::class,

            // 将cookie添加到响应当中
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,

            // 开启回话
            \Illuminate\Session\Middleware\StartSession::class,

            // 认证用户，此中间件以后 Auth 类才能生效
            // 见：https://d.laravel-china.org/docs/5.5/authentication 
            // \Illuminate\Session\Middleware\AuthenticateSession::class,

            // 将系统的错误数据注入到视图变量$errors中
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,

            // 检验csrf,防止跨站请求伪造的安全威胁
            // 见:https://d.laravel-china.org/docs/5.5/csrf
            \App\Http\Middleware\VerifyCsrfToken::class,

            // 处理路由绑定
            // 见：https://d.laravel-china.org/docs/5.5/routing#route-model-binding
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            // 记录用户最后的活跃时间
            \App\Http\Middleware\RecordLastActivedTime::class,
        ],

        // api中间件,应用于routes/api.php路由文件
        'api' => [

            // 使用别名来调用中间件
            // 请见：https://d.laravel-china.org/docs/5.5/middleware#为路由分配中间件
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * 中间件别名设置,准许你是用别名调用中间件,例如上面的api中间件组的调用
     *
     */
    protected $routeMiddleware = [

        // 只有登录的用户才能访问,我的控制器的构造的方法中大量使用
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,

        // HTTP Basic Auth认证
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,

        // 处理路由绑定
       // 见：https://d.laravel-china.org/docs/5.5/routing#route-model-binding
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,

        // 用户的授权功能
        'can' => \Illuminate\Auth\Middleware\Authorize::class,

        // 只有游客才可以访问,在register和login请求中使用,只有未登录用户才访问这些页面
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

        // 访问节流,类似于1分钟只能请求使用10请求,一般在API中使用
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
