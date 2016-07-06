@extends('layouts.main')
	@section('title')
	    Site Name - Site Description
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
				@foreach($comments as $comment)
	    			{{$comment}}
	    		@endforeach		
			</div>
	  	</div>
	@endsection
	@section('script')
		 
	@endsection
