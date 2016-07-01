@extends('layouts.main')

@section('title')
    CodeBook - {{$showuser->username}}'s Profile
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
			              		<a class="first-item" href="#">User's Posts</a>
			            	</li>
				            <li>
				              <a href="#">Saved Posts</a>
				            </li>
				            <li>
				              <a href="#">Comments</a>
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
  		<div class="medium-3 columns">
	  		<div class="profile-card">
	  			<div class="media-object">
				  	<div class="media-object-section top">
				    	<div class="thumbnail">
				            <img src="{{ $showuser->userImage() }}" />
				    	</div>
				  	</div>
				  	<div class="media-object-section">
			        	<p>{{ $showuser->username }}
			        		<br>
				        	<small><?php echo '@'?>{{ $showuser->slug }}</small>
				        </p>
				  	</div>
				  	<br>
		        	@if($myprofile)
				        <a class="button small hollow expanded" href="{{ route('user.get-editprofile') }}">
						  	<i class="fa fa-pencil"></i>
						  	Засах
						</a>
				    @else
		      			@if(!empty($user))
					        <button class="button small hollow expanded clickFollow" data-id="{{$showuser->id}}">
				      			@if (!$user->followCheck($showuser->id))
									  	<i class="fa fa-user-plus"></i>
									  	<span class="is-hidden-mobile">Дагах</span>
								@else
									  	<i class="fa fa-check-square"></i>
									  	<span class="is-hidden-mobile">Дагаж байгаа</span>
								@endif
							</button>
						@else
							<button class="button small hollow expanded" data-toggle="loginModal">
							  	<i class="fa fa-user-plus"></i>
							  	<span>Дагах</span>
							</button>
						@endif
					@endif
				</div>
		    	<div class="content">
		    		@if(!empty($showuser->bio))
	    				<p>{{ $showuser->bio }}</p>
		    		@endif
		    		@if((!empty($showuser->first_name))||(!empty($showuser->last_name)))
			    		<p>
		    				<i class="fa fa-user"></i>
		    				{{ $showuser->first_name }}
		    				{{ $showuser->last_name }}
	    				</p>
		    		@endif
		    		@if(!empty($showuser->webblog))
		    			<p>
		    				<i class="fa fa-link"></i>
		    				<a href="{{ $showuser->webblog }}" target="_blank">{{ $showuser->webblog }}</a>
		    			</p>
		    		@endif
		    		@if(!empty($showuser->company))
		    			<p>
		    				<i class="fa fa-building-o"></i>
		    				{{ $showuser->company }}
		    			</p>
		    		@endif
		      		<small>Хамгийн сүүлд</small> <small class="momentjs" data-date="{{ $showuser->last_login}}"></small><small> нэвтэрсэн</small>
		    	</div>
			</div>
			<div class="profile-card">
			  	<div class="card-content">
			    	<div class="content">
			    		@if(!$showuser->following_count == '0')
					    	<a href="{{ route('user.showFollowing', array('slug' => $showuser->slug)) }}">
					    		<h4>Following {{ $showuser->following_count }}</h4>
					    	</a>
				    		@foreach($followings as $man)
					            <a href="{{route('user.profile', array('slug' =>$man->slug))}}">
						            <img src="{{ $man->userImage() }}" />
						        </a>
				    		@endforeach
				    	@endif
				    	@if(!$showuser->followers_count == '0')
					    	<a href="{{ route('user.showFollowers', array('slug' => $showuser->slug)) }}">
						    	<h4>
						    		Followers {{ $showuser->followers_count }}
						    	</h4>
					    	</a>
				    		@foreach($followers as $man)
					            <a href="{{route('user.profile', array('slug' =>$man->slug))}}">
						            <img src="{{ $man->userImage() }}" />
						        </a>
				    		@endforeach
				    	@endif
				    	<h4>Дагаж буй тагууд</h4>
						@foreach($followtags as $tag)
				            <a href="{{route('tag.showbySlug', array('slug' =>$tag->slug))}}">
					    		<span>{{$tag->name}} ({{ $tag->post_count}})</span>
				    		</a>
			    		@endforeach
			    	</div>
			  	</div>
			</div>
		</div>
		<div class="medium-9 columns">
			@foreach($posts as $post)
    			@include('post.list')
    		@endforeach		
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
