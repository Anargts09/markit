<div class="profile-card">
	<div class="media-object">
		<a href="{{route('user.profile', array('slug' => $listitem->slug))}}">
		  	<div class="media-object-section">
		    	<div class="thumbnail">
		            <img src="{{ $listitem->userImage() }}" />
		    	</div>
		  	</div>
		  	<div class="media-object-section">
		    	<p>{{ $listitem->username }}
		    		<br>
		        	<small><?php echo '@'?>{{ $listitem->slug }}</small>
		        </p>
		  	</div>
		</a>
	  	<br>
		@if(!empty($user))
			@if($listitem->id == $user->id)
				<a class="button small hollow expanded" href="{{ route('user.get-editprofile') }}">
				  	<i class="fa fa-pencil"></i>
				  	Засах
				</a>
			@else
		        <button class="button small hollow expanded clickFollow" data-id="{{$listitem->id}}">
		  			@if (!$user->followCheck($listitem->id))
						  	<i class="fa fa-user-plus"></i>
						  	<span class="is-hidden-mobile">Дагах</span>
					@else
						  	<i class="fa fa-check-square"></i>
						  	<span class="is-hidden-mobile">Дагаж байгаа</span>
					@endif
				</button>
			@endif
		@else
			<button class="button small hollow expanded" data-toggle="loginModal">
			  	<i class="fa fa-user-plus"></i>
			  	<span>Дагах</span>
			</button>
		@endif
	</div>
</div>