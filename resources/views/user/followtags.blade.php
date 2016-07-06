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
			<h4>Followed tags </h4>
			<div class="menu-table">
        	{!! $tags->render() !!}
	    	</div>
	    	<br>
		  	<div class="row small-up-2 medium-up-3">
			@foreach($tags as $tag)
				<div class="column">
					<div class="tag-card">
						<!-- <a href="{{route('tag.showbySlug', array('slug' => $tag->slug))}}">
				            <img src="{{ $tag->tag_image}}" />
			            </a> -->
			            <a href="{{route('tag.showbySlug', array('slug' =>$tag->slug))}}">
							<div class="single-tag"><span>{{$tag->name}}</span></div>
						</a>
			            <a href="{{route('tag.showbySlug', array('slug' =>$tag->slug))}}">
							<div class="row medium-up-3 tag-info">
								<div class="column">
									<b><i class="fa fa-pencil-square-o"></i> {{$tag->post_count}} </b>
									<small>Posts</small>
								</div>
								<div class="column">
									<b><i class="fa fa-users"></i> {{ $tag->follower_count }} </b>
									<small>Followers</small>
								</div>
								<div class="column">
									<b><i class="fa fa-user"></i> {{ $tag->user_count }}</b>
									<small>Users</small>
								</div>
							</div>
						</a>
						<br>
						@if(!empty($user))
				        	@if (!$user->tagFollowCheck($tag->id))
						        <button class="button small hollow expanded tagFollow" data-id="{{$tag->id}}">
								  	<i class="fa fa-tags"></i>
								  	Дагах
								</button>
							@else
								<button class="button small hollow expanded tagUnfollow" data-id="{{$tag->id}}">
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
				</div>
			@endforeach	
        </div>
			<div class="menu-table">
	        	{!! $tags->render() !!}
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
