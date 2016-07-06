<div class="article-list">
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
	<a href="{{route('post.showbySlug', array('slug' =>$post->slug))}}">
		<h4 class="article-title">{{$post->title}}</h4>
	</a>
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
