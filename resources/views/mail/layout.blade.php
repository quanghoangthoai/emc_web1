<html>
<head>
<title></title>
<style>
a {color:#3F74B8}
</style>
</head>
<body style="font:15px/1.35 'Helvetica Neue',Arial,sans-serif;color:#333333">
	<div style="background-color:#F0F0F0;padding:10px">
		<div style="border:1px solid #D8DFE6;background-color:#FFFFFF;padding:20px 10px 30px 10px">
			<div>
				<h1 style="color:#3F74B8;font-size:18px;border-bottom:solid 1px #D8DFE6;margin-top:0;padding-top:0;padding-bottom:5px;margin-bottom:20px">
					@yield('mail_title')
				</h1>
				<div>
					@yield('mail_content')
				</div>
			</div>
		</div>
		<div style="padding:10px 0;color:#666666;font-size:13px">
			<div style="margin-bottom:5px">
				<a href="{{ URL::to('/') }}" style="color:#666666;text-decoration:none">{{ cms_get_config('site_name') }}</a>
				<br/>
				{{ cms_get_config('site_description') }}
			</div>
			<div style="font-size:10px">
				©
				<a href="{{ URL::to('/') }}" style="color:#666666;text-decoration:none">{{ cms_get_config('site_name') }}</a>
				. All rights reserved.
			</div>
		</div>
	</div>
</body>
</html>