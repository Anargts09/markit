@extends('layouts.main')

@section('title')
    CodeBook - Site Description
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
  	<div class="row">
  		<div class="columns medium-9">
	  		<div class="all-content"></div>
	  		<div class="feed-content"></div>
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
					ajaxPagination('{{ url('/postsajax')}}', 'null', 'all-content');
				});
				jQuery(document).ready(function() {
					ajaxPagination('{{ url('/feedajax')}}', 'null', 'feed-content');
				});
		</script>
	@endsection
