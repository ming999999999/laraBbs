<?php

namespace App\Handlers;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler
{
	public function translate($text)
	{
		// 实例化客户端
		$http = new Client;

		// 初始化配置信息
		$api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
		$appid = config('services.baidu_translate.key');
		$salt = time();

		// 如果没有配置百度翻译,自动使用兼容的拼音方案
		if(empty($appid)||empty($key))
		{
			return $this->pingyin($text);
		}

		//根据文档生成sign
		$sign = md5($appid.$text.$salt.$key);

		 //构建请求参数
		 $query = http_build_query([
		 	"q" => $text,
		 	'from'=>'zh',
		 	"to"=>'en',
		 	"appid"=>$appid,
		 	"salt"=>$salt,
		 	"sign"=>$sign,
		 ]);

		 // 发送Http get请求
		 $response = $http->get($api.$query);

		 $result = json_decode($response->getBody(),true);

		 // 尝试获取翻译的结果
		 if(is_set($result['trans_result'][0]['dst']))
		 {
		 	return str_slug($result['tans_result'][0]['dst']);
		 }else
		 {
		 	// 如果百度翻译没有结果,使用拼音作为后备计划
		 	return $this->pinyin($text);
		 }
	}

	public function pinyin($text)
	{

		return str_slug(app(Pinyin::class)->permalink($text));
	}
}