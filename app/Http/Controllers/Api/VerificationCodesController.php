<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\VerificationCodeRequest;


class VerificationCodesController extends Controller
{

    public function store(VerificationCodeRequest $request)
    {

        // return $this->response->array(['test_message' => 'store verification code']);

    	header("Content-Type:text/html;charset=utf-8");
	    $apikey = "2e880c55941eaf4a08eca1f4b7cb354a";
	     //修改为您的apikey(https://www.yunpian.com)登录官网后获取
	    $mobile = "18810448544"; //请用自己的手机号代替
	    $text="2175230";
	    $ch = curl_init();

	    /* 设置验证方式 */
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8',
	        'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
	    /* 设置返回结果为流 */
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	    /* 设置超时时间*/
	    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

	    /* 设置通信方式 */
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


        $data = str_pad(random_int(1,9999),4,0,STR_PAD_LEFT);

        if(!app()->environment('production'))
        {
            $data = '1234';
        }else
        {

            try{

                // 发送模板短信
                // 需要对value进行编码
                $data = array('tpl_id' => '2175230', 'tpl_value' => ('#code#').
                    '='.urlencode($data), 'apikey' => $apikey, 'mobile' => $mobile);
                
                $json_data = $this->tpl_send($ch,$data);
                $array = json_decode($json_data,true);
             

                curl_close($ch);

            }catch(\GuzzleHttp\Exception\ClientException $exception)
            {
                $response = $exception->getResponse();
                $result = json_decode($response->getBody()->getContents(), true);
                return $this->response->errorInternal($result['msg'] ?? '短信发送异常');
            }


        }

            $phone = $mobile;

            $key = "verificationCode_".str_random(15);

            $expiredAt = now()->addMinutes(10);

            // 缓存验证码10分钟过期
           \Cache::put($key,['phone'=>$phone,'code'=>$data],$expiredAt);

            return $this->response->array([
                'key'=>$key,
                'expired_at'=>$expiredAt->toDateTimeString(),
            ])->setStatusCode(201);

	   

    }


     /************************************************************************************/
    //获得账户
    function get_user($ch,$apikey)
    {
        curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/user/get.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $apikey)));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result,$error);
        return $result;
    }


    function send($ch,$data)
    {
        curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result,$error);
        return $result;
    }


    function tpl_send($ch,$data)
    {
        curl_setopt ($ch, CURLOPT_URL,
            'https://sms.yunpian.com/v2/sms/tpl_single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result,$error);
        return $result;
    }


    function voice_send($ch,$data)
    {
        curl_setopt ($ch, CURLOPT_URL, 'http://voice.yunpian.com/v2/voice/send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result,$error);
        return $result;
    }


    function notify_send($ch,$data)
    {
        curl_setopt ($ch, CURLOPT_URL, 'https://voice.yunpian.com/v2/voice/tpl_notify.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $this->checkErr($result,$error);
        return $result;
    }


    function checkErr($result,$error) 
    {
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
