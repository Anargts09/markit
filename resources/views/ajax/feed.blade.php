@if($feedcount == '0')
	<a class="button" href="{{route('tag.listAll')}}">All tag</a>
	<a class="button" href="{{ route('user.listUser') }}">All User</a> 
@endif
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
		@if($type == 'user')
				<a href="{{route('user.profile', array('slug' => $post->author->slug))}}">
		            <img src="{{ $post->author->userImage()}}" />
	            </a>
	    @elseif($type == 'tag')
	  			<a href="{{route('tag.showbySlug', array('slug' =>$followedtag->slug))}}">
		            <img src="{{ $tag->tag_image }}" />
		            <i class="fa fa-tag icon"></i>
	    		</a>
	    @else
				<a href="{{route('user.profile', array('slug' => $followeduser->slug))}}">
		            <img src="{{ $followeduser->userImage()}}" />
		            <i class="fa fa-folder icon"></i>
	            </a>
	    @endif
		@if($type == 'user')
			<a href="{{route('user.profile', array('slug' => $post->author->slug))}}">
				{{ $post->author->username}}
			</a>
		@elseif($type == 'tag')
			<a href="{{route('tag.showbySlug', array('slug' => $followedtag->slug))}}">
				{{ $followedtag->name}}
			</a>
		@else
			<a href="{{route('user.profile', array('slug' => $followeduser->slug))}}">
				{{ $followeduser->username}}
			</a>
		@endif
		<a href="{{route('post.showbySlug', array('slug' =>$post->slug))}}">
			<h4>{{$post->title}}</h4>
		</a>
		@foreach($post->tags as $tag)
			<a href="{{route('tag.showbySlug', array('slug' =>$tag->slug))}}">
				<span>{{$tag->name}}</span>
			</a>
		@endforeach
	</div>
@endforeach	
@if($feedposts->hasMorePages())
	<br>
	<a data-content="feed-content" data-url="{{$feedposts->nextPageUrl()}}">
		Show More
	</a>
@endif
