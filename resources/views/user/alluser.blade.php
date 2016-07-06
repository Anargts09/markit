@extends('layouts.main')
	@section('title')
	    Site Name - Site Description
	@endsection
	@section('token')
		<meta name="csrf-token" content="{{ csrf_token() }}" />
	@endsection
	@section('navbar')
		<div data-sticky-container>
			<div class="title-bar sub-title-bar" data-sticky data-options="marginTop:0;" style="width:100%" data-top-anchor="40" data-sticky-on="small">
		    	<div class="row column">
				    <div class="sub-menu">
				        <div class="top-bar-left">
				          	<ul class="menu">
				            	<li class="{{ $active == 'alluser' ? 'is-active' : ''}}">
				              		<a class="first-item" href="{{route('user.listUser')}}">All Users</a>
				            	</li>
				            	<li class="{{ $active == 'alltag' ? 'is-active' : ''}}">
				              		<a href="{{route('tag.listAll')}}">All Tags</a>
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
		<div class="menu-table">
        	{!! $users->render() !!}
    	</div>
	  	<div class="row small-up-2 medium-up-3 large-up-4">
    		@foreach($users as $listitem)
				<div class="column">
					@include('user.list')
				</div>
			@endforeach
        </div>
		<div class="menu-table">
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
