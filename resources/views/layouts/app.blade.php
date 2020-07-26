<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Fonts -->
		<link rel="dns-prefetch" href="//fonts.gstatic.com">
		<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		
		<!-- Styles -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	</head>
	<body>
		<div id="app">

			@if ($errors->any())
			<div class="js-alert-box alert alert-danger alert-dismissible fade show" role="alert">
				@foreach ($errors->all() as $error)
				<div>{{ $error }}</div>
				@endforeach
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@endif

			@if(session()->get('success'))
				@include('includes.alert_success', ['message' => session()->get('success')])
			@endif
			
			<main class="py-4">
				@yield('content')
			</main>
		</div>
		
		<!-- Scripts -->
		<script type="text/javascript" src='https://code.jquery.com/jquery-latest.min.js'></script>
		<script type="text/javascript" src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js'></script>
		<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
		@section('footer_script')
		@show
	</body>
</html>
