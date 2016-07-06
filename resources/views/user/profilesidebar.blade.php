<div class="profile-card">
		<div class="media-object">
	  	<div class="media-object-section">
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
		<div class="clearfix">
			@if(count($showuser->tags) != 0)
				<h5>Skill</h5>
				@foreach($showuser->tags as $tag)
					<a href="{{route('tag.showbySlug', array('slug' =>$tag->slug))}}">
						<div class="single-tag"><span>{{$tag->name}}</span><b>{{$tag->post_count}}</b></div>
					</a>
				@endforeach
			@endif
		</div>
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
		    		<h5>Following {{ $showuser->following_count }}</h5>
		    	</a>
	    		@foreach($followings as $man)
		            <a href="{{route('user.profile', array('slug' =>$man->slug))}}">
			            <img src="{{ $man->userImage() }}" />
			        </a>
	    		@endforeach
	    	@endif
	    	@if(!$showuser->followers_count == '0')
		    	<a href="{{ route('user.showFollowers', array('slug' => $showuser->slug)) }}">
			    	<h5>
			    		Followers {{ $showuser->followers_count }}
			    	</h5>
		    	</a>
	    		@foreach($followers as $man)
		            <a href="{{route('user.profile', array('slug' =>$man->slug))}}">
			            <img src="{{ $man->userImage() }}" />
			        </a>
	    		@endforeach
	    	@endif
	    	@if(count($showuser->followtags) !== '0')
		    	<a href="{{route('user.showFollowTags', array('slug' => $showuser->slug))}}">
			    	<h5>Дагаж буй тагууд</h5>
		    	</a>
		    	<div class="clearfix">
					@foreach($followtags as $tag)
						<a href="{{route('tag.showbySlug', array('slug' =>$tag->slug))}}">
							<div class="single-tag"><span>{{$tag->name}}</span><b>{{$tag->post_count}}</b></div>
						</a>
		    		@endforeach
	    		</div>
		    @endif
    	</div>
  	</div>
</div>