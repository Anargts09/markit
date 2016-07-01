<div class="article-list">
	<a href="{{route('user.profile', array('slug' => $post->author->slug))}}">
	    <img src="{{ $post->author->userImage()}}" />
	</a>
	<a href="{{route('user.profile', array('slug' => $post->author->slug))}}">
		{{ $post->author->username}}
	</a>
	<small class="momentjs" data-date="{{ $post->created_at}}"></small>
	<a href="{{route('post.showbySlug', array('slug' =>$post->slug))}}">
		<h4>{{$post->title}}</h4>
	</a>
	@foreach($post->tags as $tag)
		<a href="{{route('tag.showbySlug', array('slug' =>$tag->slug))}}">
			<span>{{$tag->name}}</span>
		</a>
	@endforeach
	<i class="fa fa-bookmark-o"></i><small>{{ $post->save_count }} </small>
	<i class="fa fa-comment-o"></i><small>{{ $post->comment_count }}</small>
</div>
