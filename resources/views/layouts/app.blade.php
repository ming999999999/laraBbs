<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<title>@yield('title','LaraBBS')</title>
	<meta  name="description" content="@yield('description','laravelBBS')" charset="utf-8">

	<!-- Styles -->
	<link rel="stylesheet"  href="{{ asset('css/app.css')}}">
	@yield('styles')
</head>
<body>
	<div id="app" class="{{ route_class() }}-page">
		<!-- 引入头部文件 -->
		@include('layouts._header')

		<div class="container">

			<!-- 引入报错信息 -->
			@include('layouts._message')
			
			<!-- 内容部分的继承 -->
			@yield('content')

		</div>
		<!-- 引入底部文件 -->
		@include('layouts._footer')
	</div>

	<!-- 引入用户切换 -->
	 
	<!-- Script -->
	<script src="{{asset('js/app.js')}}"></script>
	@yield('scripts')
</body>
</html>