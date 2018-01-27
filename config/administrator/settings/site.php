<?php

	return [
		'title'=>'站点配置',

		// 访问权限的判断
		'permissions'=>function()
		{

			// 只允许站长管理站点配置
			return Auth::user()->hasRole('Founder');
		},

		// 站点配置的表单
		'edit_fields'=>[
			'site_name'=>[
				// 表单标题
				'title'=>'站点名称',

				// 表单条目的类型
				'type'=>'text',

				// 数字限制
				'limit'=>50,
			],

			'contact_email'=>[
				'title'=>'联系人邮箱',
				'type'=>'text',
				'limit'=>50,
			],

			'seo_description'=>[
				'title'=>'SEO-Description',
				'type'=>'textarea',
				'limit'=>250,
			],

			'seo_keyword'=>[
				'title'=>'SEO-Keywords',
				'type'=>'textarea',
				'limit'=>250,
			],
		],

		// 表单的验证规则
		'rules'=>[
			'site_name'=>'required|max:50',
			'contact_email'=>'email',
		],

		'messages'=>[
			'site_name.required'=>'请填写站点名称',
			'contact_email.email'=>'请填写正确的联系人的邮箱格式',
		],

		// 数据即将保持的触发的钩子,可以对用户提交的数据修改
		'before_save'=>function(&$data)
		{
			// 为网站名称加上后缀,加上判断是为了防止多次添加
			if(strpos($data['site_name'],'Powered by LaraBBS')===false){
				$data['site_name'] .= '-Powered by LaraBBS';
			}

		},


		// 你可以自定义多个动作,每个动作为设置页面的地部的其他操作的区块

		'actions'=>[
			// 清空缓存
			'clear_cache'=>[
				'title'=>'更新系统缓存',

				// 不同状态是页面的提醒
				'messages'=>[

					'active'=>'正在清空缓存...',
					'success'=>'缓存已清空!',
					'error'=>'清空缓存时出错',
				],

				//动作的执行代码,注意你可以通过修改$data参数更改配置信息
				'action'=>function(&$data)
				{
					\Artisan::call('cache:clear');
					return true;
				}
			],
		],
	];