<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\VerificationCodeRequest;
use Overtrue\EasySms\EasySms;

$config = [
    // HTTP 请求的超时时间（秒）
    'timeout' => 5.0,

    // 默认发送配置
    'default' => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        // 默认可用的发送网关
        'gateways' => [
            'yunpian',
        ],
    ],
    // 可用的网关配置
    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],
        'yunpian' => [
            'api_key' => '2e880c55941eaf4a08eca1f4b7cb354a',
        ],
    ],
];

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request,EasySms $easySms)
    {
    	// $phone = $request->phone;
    	$phone = 18810448544;

    	// 生成4位随机的数,左侧补0;
    	$code = str_pad(random_int(1,9999),4,0,STR_PAD_LEFT);

    	try{
    		$result = $easySms->send(18810448544,[
    			'content'=>"lbbs社区.你的验证码是{$code}.如非本人操作,请忽略本短信",
    			'template'=>'2175230',
    		]);
    	}catch(\GuzzleHttp\Exception\ClientException $exception){
    		$response = $exception->getResponse();
    		$result = json_decode($response->getBody()->getContents(),true);
    		return $this->response->errorInternal($result['msg'] ?? '短息发送异常');
    	}

    	$key = 'verificationCode_'.str_random(15);

    	$expiredAt = now()->addMinutes(10);

    	// 缓存验证码十分钟
    	\Cache::put($key,['phone'=>$phone,'code'=>$code],$expiredAt);

    	return $this->response->array([
    		'key'=>$key,
    		'expired_at'=>$expiredAt->toDateTimeString(),

    	])->setStatusCode(201);

    }
}
