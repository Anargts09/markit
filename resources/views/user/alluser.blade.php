@extends('layouts.main')
	@section('title')
	    Site Name - Site Description
	@endsection
	@section('token')
		<meta name="csrf-token" content="{{ csrf_token() }}" />
	@endsection
	@section('navbar')
		    <div class="title-bar sub-title-bar">
		    	<div class="row column">
				    <div class="sub-menu">
				        <div class="top-bar-left">
				          	<ul class="menu">
				            	<li>
				              		<a class="first-item" href="#">All Post</a>
				            	</li>
				            	<li>
				              		<a href="#">Feed</a>
				            	</li>
				          	</ul>
				        </div>
				        <div class="top-bar-right">
				        	@include('include.search')
				        </div>
				    </div>
				</div>
			</div>
		</div>
	@endsection
	@section('content')
	  	<div class="row column">
    		@foreach($users as $listitem)
				<div class="columns medium-4">
					@include('user.list')
				</div>
			@endforeach	
        	{!! $users->render() !!}
        </div>
	@endsection
	@section('script')
		 @if(!empty($user))
		    <script type="text/javascript">
				$(function () {
				    $.ajaxSetup({
				        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
				    });
				});
			</script>
		@endif
	@endsection
