@extends('layouts.main')
@section('title')
    Site Name - Site Description
@endsection

@section('token')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('style')
    <link href="{{ asset('/css/markdown.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/highlight/styles/agate.css') }}" rel="stylesheet">
    @if(!empty($user))
	    <link href="{{ asset('/bower_components/simplemde/dist/simplemde.min.css') }}" rel="stylesheet">
    @endif
@endsection

@section('navbar')
	<div data-sticky-container>
		<div class="title-bar sub-title-bar" data-sticky data-options="marginTop:0;" style="width:100%" data-top-anchor="40" data-sticky-on="small">
			<div class="row column">
			    <div class="sub-menu">
			        <div class="top-bar-left">
			          	<ul class="menu">
			            	<li>
						      	@if($mypost)
							      	<a href="{{route('post.editPost', array('slug' =>$post->slug))}}" class="first-item">
							      		<i class="fa fa-pencil"></i> Edit
						      		</a>
						      	@else
						      		@if(!empty($user))
								      	<button class="first-item saveButton"  data-id="{{$post->id}}">
								        	@if (!$user->postSaveCheck($post->id))
									      		<i class="fa fa-bookmark-o"></i> save {{$post->save_count}}
								      		@else
									      		<i class="fa fa-bookmark"></i> saved {{$post->save_count}}
								      		@endif
							      		</button>
						      		@else
								      	<a class="first-item" data-toggle="loginModal">
								      		<i class="fa fa-bookmark-o"></i> save {{$post->save_count}}
							      		</a>
						      		@endif
						      	@endif
			            	</li>
					      	@if($mypost)
						      	<li>
							      	<a href="#">
							      		<i class="fa fa-bookmark"></i> {{$post->save_count}} saved
						      		</a>
						      	</li>
					      	@endif
			            	<li>
			            		<a href="#post-comments" data-tooltip aria-haspopup="false" data-disable-hover="false" tabindex="1" title="Comments.">
				            		<i class="fa fa-comment-o"></i> {{$post->comment_count}} comments
							  	</a>
			            	</li>
			          	</ul>
			        </div>
			        <div class="top-bar-right">
			        	@include('include.search')
			        </div>
			    </div>
			</div>
		</div>
	</div>
	<div class="article-box">
@endsection

@section('content')
		<div class="row">
			<div class="columns medium-8 medium-push-2">
				@include('post.author')
		  		<div class="article-tags">
					@foreach($tags as $tag)
						<a href="{{route('tag.showbySlug', array('slug' =>$tag->slug))}}">
							<div class="single-tag"><span>{{$tag->name}}</span><b>{{$tag->post_count}}</b></div>
						</a>
			  		@endforeach
		  		</div>
				<h3 class="post-title">
			  		{{ $post->title  }}
		  		</h3>
				@include('include.status')
				<div class="markdown-body article-body">
					{!! $markdown !!}
				</div>
				@include('post.author')
			</div>
		</div>
	</div>
@endsection
@section('comment')
		<div class="row padding50">
			<div class="columns medium-8 medium-push-2">
				<h5 class="comment-header">Comments</h5>
				<div id="post-comments">
					@include('include.comments')
				</div>
			</div>
		</div>
@endsection

	@section('script')
    {!! HTML::script('js/min/highlight.pack.js') !!}
    @if(!empty($user))
	    {!! HTML::script('bower_components/simplemde/dist/simplemde.min.js') !!}

	    <script>
		    var simplemde = new SimpleMDE({
			    element: document.getElementById("commentPane"),
			    hideIcons: ["guide", "bold", "italic", "image"],
			    renderingConfig: {
			        singleLineBreaks: true,
			        codeSyntaxHighlighting: true,
			    },
			    showIcons: ["code"],
			    spellChecker: false,
			});
	    </script>
	@endif
	<script type="text/javascript">
		$(function () {
		    $.ajaxSetup({
		        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
		    });
		});
	    // Highlight
	    jQuery(document).ready(function() {
		    hljs.initHighlightingOnLoad();
	        ajaxPagination('{{ url('/post/'. $post->slug .'/comments')}}', 'null', 'comment-content');
	    });
	</script>
@endsection
