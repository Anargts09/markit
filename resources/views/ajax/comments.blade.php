@foreach($result as $k => $comment)
	<div class="comment-box">
		<div class="comment-author">
			<div class="media-object">
				<div class="media-object-section">
					<a href="{{route('user.profile', array('slug' => $comments[$k]->user->slug))}}">
					    <img class="img-circle" src="{{ $comments[$k]->user->userImage()}}"/>
					</a>
				</div>
				<div class="media-object-section main-section">
					<a href="{{route('user.profile', array('slug' => $comments[$k]->user->slug))}}">
						{{ $comments[$k]->user->username}}
					</a>
			  		<small class="momentjs" data-date="{{ $comments[$k]->created_at}}"></small>
		  		</div>
	  		</div>
		</div>
		<div class="markdown-body markdown-comment">
			{!! $comment !!}
		</div>
		<div class="my-comment">
			@if(!empty($user))
				@if($user->id == $comments[$k]->user->id)
					<i class="fa fa-ellipsis-v"></i>
				@endif
			@endif
		</div>
	</div>
@endforeach
@if($comments->hasMorePages())
  <a class="pagination-link button hollow small expanded" data-content="comment-content" data-url="{{$comments->nextPageUrl()}}">
    {{ trans('home.showmore')}}
  </a>
@endif