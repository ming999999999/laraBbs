<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Request\Api\UserRequest;
// use App\Http\Controllers\Controller;

class UsersController extends Controller
{

	public function store(UserRequest $request)
	{
		$verifyData = \Cache::get($request->verificaton_key);

		if(!$verifyData)
		{
			return $this->response->error('验证码失效',422);
		}

		if(!hash_equals($verifyData['code'],$request->verification_code))
		{
			return $this->reponse->errorUnauthorized('验证码错误');
		}

		$user = User::create([
			'name'=>$request->name,
			'phone'=>$verifyData['phone'];
			'password'=>bcrypt($resquest->password),
		]);

		// 清除验证码缓存
		\Cache::forget($request->verification_key);

		return $this->response->created();

	}
    
}
