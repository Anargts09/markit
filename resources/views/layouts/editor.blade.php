<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>
        @yield('title')
    </title>
    @yield('token')
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/markdown.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/highlight/styles/agate.css') }}" rel="stylesheet">
    <link href="{{ asset('/bower_components/simplemde/dist/simplemde.min.css') }}" rel="stylesheet">

	@yield('style')

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<!--[if lt IE 8]>
	    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->

    
    @include('layouts.navbar')

    @yield('navbar')
    
    <div id="mainContent">
    	@yield('content')
    </div>


	<!-- Scripts -->
    {!! HTML::script('bower_components/jquery/dist/jquery.min.js') !!}
    {!! HTML::script('bower_components/foundation-sites/dist/foundation.min.js') !!}
    {!! HTML::script('bower_components/moment/min/moment.min.js') !!}

    {!! HTML::script('bower_components/simplemde/dist/simplemde.min.js') !!}

    <!-- {!! HTML::script('js/min/script.js') !!} -->
    {!! HTML::script('js/min/editor.js') !!}

    {!! HTML::script('js/min/inputtag.js') !!}
    {!! HTML::script('js/min/highlight.pack.js') !!}
    {!! HTML::script('js/min/jqueryui.js') !!}
	@yield('script')    
</body>
</html>
