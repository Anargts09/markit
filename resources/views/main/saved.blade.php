@extends('layouts.main')

@section('title')
    CodeBook - Site Description
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
			            	<li class="{{ $active == 'index' ? 'is-active' : ''}}">
			              		<a class="first-item" href="{{ route('index') }}">All Post</a>
			            	</li>
			            	@if(!empty($user))
				            	<li class="{{ $active == 'feed' ? 'is-active' : ''}}">
				              		<a href="{{ route('feed') }}">Feed</a>
				            	</li>
			            		<li class="{{ $active == 'saved' ? 'is-active' : ''}}">
				              		<a href="{{ route('saved') }}">Saved Posts</a>
				            	</li>
			            	@else
			            		<li data-toggle="loginModal">
				              		<a href="#">Feed</a>
				            	</li>
			            	@endif
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
  	<div class="row">
  		<div class="columns medium-9">
	  		<div class="saved-content"></div>
  		</div>
  		<div class="columns medium-3"></div>
  	</div>
@endsection

@section('script')
		<script type="text/javascript">
			$(function () {
			    $.ajaxSetup({
			        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
			    });
			});
				jQuery(document).ready(function() {
					ajaxPagination('{{ url('/savedajax')}}', 'null', 'saved-content');
				});
		</script>
	@endsection
