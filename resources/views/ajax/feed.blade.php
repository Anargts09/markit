@foreach($feedposts as $post)
	<?php  $type = 'save'; ?>
	<?php  $followedtag = '';?>
	<?php  $followeduser = '';?>
	@if($user->followCheck($post->author->id))
		<?php  $type = 'user'; ?>
	@else
		@foreach($post->tags as $tag)
	    	@if (($user->tagFollowCheck($tag->id))&&(empty($followedtag)))
				<?php  $type = 'tag'; ?>
	    		<?php $followedtag = $tag; ?>
	    	@endif
		@endforeach
	@endif
	@if($type == 'save')
		@foreach($post->savedusers as $fu)
	    	@if (($user->followCheck($fu->id))&&(empty($followeduser)))
	    		<?php $followeduser = $fu; ?>
	    	@endif
		@endforeach
	@endif
	<div class="article-list">
		<div class="clearfix">
			@if($type == 'user')
				<div class="media-object">
				  	<div class="media-object-section">
				  		<a href="{{route('user.profile', array('slug' => $post->author->slug))}}">
				            <img src="{{ $post->author->userImage()}}" />
			            </a>
					</div>
				  	<div class="media-object-section">
						<a href="{{route('user.profile', array('slug' => $post->author->slug))}}" class="list-author">
							{{ $post->author->username}}
						</a>
						<small class="momentjs" data-date="{{ $post->created_at}}"></small>
					</div>
				</div>
		    @elseif($type == 'tag')
				<a href="{{route('tag.showbySlug', array('slug' => $followedtag->slug))}}">
					<div class="single-tag"><span>{{$followedtag->name}}</span><b>{{$followedtag->post_count}}</b></div>
				</a>
				<small> -т шинээр нэмэгдсэн</small>
			@else
				<div class="media-object">
				  	<div class="media-object-section">
				  		<a href="{{route('user.profile', array('slug' => $followeduser->slug))}}">
			            <img src="{{ $followeduser->userImage()}}" />
		            </a>
					</div>
				  	<div class="media-object-section">
						<a href="{{route('user.profile', array('slug' => $followeduser->slug))}}" class="list-author">
							{{ $followeduser->username}}
						</a>
						<small> хадгалсан </small>
					</div>
				</div>
			@endif
		</div>
		<div class="clearfix">
			<a href="{{route('post.showbySlug', array('slug' =>$post->slug))}}">
				<h4 class="article-title">{{$post->title}}</h4>
			</a>
		</div>
		<div class="clearfix">
			<div class="float-left">
				@foreach($post->tags as $tag)
					<a href="{{route('tag.showbySlug', array('slug' =>$tag->slug))}}">
						<div class="single-tag"><span>{{$tag->name}}</span><b>{{$tag->post_count}}</b></div>
					</a>
				@endforeach
			</div>
			<div class="float-right list-status">
				<a href="{{route('post.showbySlug', array('slug' =>$post->slug))}}">
					<i class="fa fa-bookmark-o"></i>{{ $post->save_count }}
				</a>
				<a href="{{route('post.showbySlug', array('slug' =>$post->slug, '#post-comments'))}}">
					<i class="fa fa-comment-o"></i>{{ $post->comment_count }}
				</a>
			</div>
		</div>
	</div>
@endforeach	
@if($feedposts->hasMorePages())
	<a class="pagination-link button hollow small expanded" data-content="feed-content" data-url="{{$feedposts->nextPageUrl()}}">
		Show More
	</a>
@endif
