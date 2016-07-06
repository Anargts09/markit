@extends('layouts.main')

@section('title')
    CodeBook - {{$showuser->username}}'s Profile
@endsection

@section('token')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('navbar')
	@include('user.usersubmenu')
@endsection
@section('content')
  	<div class="row">
  		<div class="medium-3 columns">
	  		@include('user.profilesidebar')
		</div>
		<div class="medium-9 columns">
			<h4>{{ $active == 'following' ? 'Following' : 'Followers'}} </h4>
			<div class="menu-table">
        	{!! $users->render() !!}
	    	</div>
		  	<div class="row medium-up-3 large-up-4">
	    		@foreach($users as $listitem)
					<div class="column">
						@include('user.list')
					</div>
				@endforeach
	        </div>
			<div class="menu-table">
	        	{!! $users->render() !!}
	    	</div>
		</div>
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
