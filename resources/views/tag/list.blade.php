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
			@foreach($tags as $tag)
				<div class="columns medium-4">
					<a href="{{route('tag.showbySlug', array('slug' => $tag->slug))}}">
			            <img src="{{ $tag->tag_image}}" />
		            </a>
					<a href="{{route('tag.showbySlug', array('slug' => $tag->slug))}}">
						{{ $tag->name}}
					</a>
					@if(!$tag->post_count == '0')
			    		{{ $tag->post_count }} пост, 
			    	@endif
			    	@if(!$tag->follower_count == '0')
				    	{{ $tag->follower_count }} дагагч
			    	@endif
					@if(!empty($user))
			        	@if (!$user->tagFollowCheck($tag->id))
					        <button class="button primary tagFollow" data-id="{{$tag->id}}">
							  	<i class="fa fa-tags"></i>
							  	Дагах
							</button>
						@else
							<button class="button primary tagUnfollow" data-id="{{$tag->id}}">
							  	<i class="fa fa-check-square"></i>
							  	Дагаж байгаа
							</button>
						@endif
					@else
				        <button class="button primary" data-toggle="loginModal">
						  	<i class="fa fa-tags"></i>
						  	Дагах
						</button>
					@endif
				</div>
			@endforeach	
        	{!! $tags->render() !!}
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
