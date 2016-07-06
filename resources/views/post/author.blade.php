<div class="article-author">
	<div class="media-object">
		<div class="media-object-section">
			<a href="{{route('user.profile', array('slug' => $post->author->slug))}}">
			    <img class="img-circle" src="{{ $post->author->userImage()}}"/>
			</a>
		</div>
		<div class="media-object-section main-section">
			<a href="{{route('user.profile', array('slug' => $post->author->slug))}}">
				{{ $post->author->username}}
			</a>
			@if(!empty($user))
		      	@if(!$mypost)
			        <button class="button small hollow clickFollow" data-id="{{$post->author->id}}">
			  			@if (!$user->followCheck($post->author->id))
							  	<i class="fa fa-user-plus"></i>
							  	<span class="is-hidden-mobile">Дагах</span>
						@else
							  	<i class="fa fa-check-square"></i>
							  	<span class="is-hidden-mobile">Дагаж байгаа</span>
						@endif
					</button>
				@endif
			@else
				<button class="button small hollow" data-toggle="loginModal">
				  	<i class="fa fa-user-plus"></i>
				  	<span>Дагах</span>
				</button>
			@endif
			<div class="author-litle">
		  		<small class="momentjs" data-date="{{ $post->created_at}}"></small>
				<!-- @if($post->created_at != $post->updated_at)
					<small>・(</small><small class="momentjs" data-date="{{ $post->updated_at}}"></small><small> &nbspзассан)</small>
				@endif -->
				・
				<a href="#">{{$post->save_count}} saved</a>
			</div>
		</div>
	</div>
</div>