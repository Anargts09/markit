<div id="add-comment">
	@if(!empty($user))
		<div id="commentBox" class="comment-box with-login" data-toggler data-animate="fade-in fade-out">
			<button data-toggle="addComment commentBox">
				<i class="fa fa-comment-o"></i> Write a comment...
			</button>
		</div>
		<div id="addComment" data-toggler data-animate="fade-in fade-out">
			{!! Form::open(['url' => route('comment.add', $post->slug), 'id' => 'commentForm' ]) !!}
				{!! Form::textarea('inputPane', null, [
			    	'class' 		=> 'textarea',
			    	'id'			=>  'commentPane',
			        'placeholder'   =>  'Markdown оор бичих'
			    ]) !!}
				<button class="button primary float-right" type="submit">Enter</button>
			{!! Form::close() !!}
		</div>
	@else 
		<div class="comment-box with-login">
			<button  data-toggle="loginModal">
				<i class="fa fa-comment-o"></i> Write a comment...
			</button>
		</div>
	@endif
</div>
<div id="postComments" class="comment-content">
	
</div>