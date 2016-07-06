<div class="comment-box newComment">
	<div class="comment-author">
		<a href="{{route('user.profile', array('slug' => $comment->user->slug))}}">
		    <img class="img-circle" src="{{ $comment->user->userImage()}}"/>
		</a>
		<a href="{{route('user.profile', array('slug' => $comment->user->slug))}}">
			{{ $comment->user->username}}
		</a>
  		<small class="momentjs" data-date="{{ $comment->created_at}}"></small>
	</div>
	<div class="markdown-body markdown-comment">
		{!! $markdown !!}
	</div>
</div>