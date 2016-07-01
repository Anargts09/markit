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
        <div class="row">
            <div class="columns medium-9">
				@if(!empty($tag->tag_image) )
		            <img src="{{ $tag->tag_image }}" />
	        	@endif
		      	<h1>
		        	{{ $tag->name }}
		      	</h1>
		      	<h2>
		      		@if(!$tag->post_count == '0')
			    		<small>Нийт {{ $tag->post_count }} пост, </small>
			    	@endif
			    	@if(!$tag->follower_count == '0')
				    	<small>{{ $tag->follower_count }} дагагч, </small>
			    	@endif
			    	<small class="momentjs" data-date="{{ $tag->created_at}}"></small><small> нэмэгдсэн</small> 
		      	</h2>
	        	@if(!empty($user))
		        	@if (!$user->tagFollowCheck($tag->id))
				        <button class="button primary tagFollow" data-id="{{$tag->id}}">
						  	<i class="fa fa-tags"></i> Дагах
						</button>
					@else
						<button class="button primary tagUnfollow" data-id="{{$tag->id}}">
						  	<i class="fa fa-check-square"></i> Дагаж байгаа
						</button>
					@endif
				@else
			        <button class="button primary" data-toggle="loginModal">
					  	<i class="fa fa-tags"></i> Дагах
					</button>
				@endif
            	@foreach($posts as $post)
                	@include('post.list')
	    		@endforeach	
            </div>
            <div class="columns medium-3">
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
