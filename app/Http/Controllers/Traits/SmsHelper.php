<?php
namespace App\Http\Controllers\Traits;

trait SmsHelper
{

	protected $ch = "";
	protected $apikey = "";
	protected $data = "";
	protected $result = "";
	protected $error = "";
   //获得账户
	function get_user($ch,$apikey){
	    curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/user/get.json');
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $apikey)));
	    $result = curl_exec($ch);
	    $error = curl_error($ch);
	    checkErr($result,$error);
	    return $result;
	}

	// 发送信息
	function send($ch,$data){
	    curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	    $result = curl_exec($ch);
	    $error = curl_error($ch);
	    checkErr($result,$error);
	    return $result;
	}

	// 发送魔板
	function tpl_send($ch,$data){
	    curl_setopt ($ch, CURLOPT_URL,
	        'https://sms.yunpian.com/v2/sms/tpl_single_send.json');
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	    $result = curl_exec($ch);
	    $error = curl_error($ch);
	    checkErr($result,$error);
	    return $result;
	}

	// 发送语音
	function voice_send($ch,$data){
	    curl_setopt ($ch, CURLOPT_URL, 'http://voice.yunpian.com/v2/voice/send.json');
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	    $result = curl_exec($ch);
	    $error = curl_error($ch);
	    checkErr($result,$error);
	    return $result;
	}

		
	function notify_send($ch,$data){
	    curl_setopt ($ch, CURLOPT_URL, 'https://voice.yunpian.com/v2/voice/tpl_notify.json');
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	    $result = curl_exec($ch);
	    $error = curl_error($ch);
	    checkErr($result,$error);
	    return $result;
	}

	function checkErr($result,$error) {
	    if($result === false)
	    {
	        echo 'Curl error: ' . $error;
	    }
	    else
	    {
	        //echo '操作完成没有任何错误';
	    }
	}
}
