<!DOCTYPE html>
<html ng-app="madisonApp" lang="en">
	<head>
		<meta charset="utf-8" />
		<title>{{ $page_title }}</title>
		<!-- Mobile Optimization -->
		<meta name="HandheldFriendly" content="True" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimum-scale=1.0">
		<meta name="format-detection" content="telephone=no" />
		<meta http-equiv="cleartype" content="on" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		@include('layouts.socials')
		@include('layouts.assets')
	</head>
	<body>
		<div id="wrap">
			<div id="header-main" class="header row">
				<div class="container">
				@include('layouts.header')
				</div>
			</div>
			<div class="row">
				<div class="container">
					<div class="md-col-12">&nbsp;</div>
				</div>
			</div>
			<div class="row">
				<div class="container alerts">
					@include('errors')
					@include('message')
					@include('success')
				</div>
			</div>

			<div id="main" class="row">
				<div class="container">
					<div class="row">
						@yield('content')
					</div>
				</div>
				<div id="wrap-footer"></div>
			</div>
		</div>
		<div id="footer" class="footer row">
			@include('layouts.footer')
		</div>
	</body>
</html>
