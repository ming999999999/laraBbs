<?php

	function route_class()
	{

		return str_replace('.','-',Route::currentRouteName());
	}

	function make_excerpt($value,$length=200)
	{
		$excerpt =trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));

		return str_limit($excerpt,$length);
	}


	function model_admin_link($title,$model)
	{
		return model_link($title,$model,'admin');
	}

	function model_link($title,$model,$prefix='')
	{

		// 获取数据模型的复数蛇形命名
		$model_name = model_plural_name($model);

		// 初始化前缀
		$prefix = $prefix?"/$prefix/":'/';

		// 使用站点的url拼接全量url
		$url = config('app.url').$prefix.$model_name.'/'.$model->id;
	}