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
@endsection

@section('navbar')
	    <div class="title-bar sub-title-bar">
	    	<div class="row column">
			    <div class="sub-menu">
			        <div class="top-bar-left">
			          	<ul class="menu">
			            	<li>
						      	@if($mypost)
							      	<a href="{{route('post.editPost', array('slug' =>$post->slug))}}" class="button danger">
							      		<i class="fa fa-pencil"></i> Edit
						      		</a>			      		
						      	@else
						      		@if(!empty($user))
							        	@if (!$user->postSaveCheck($post->id))
									      	<button class="button saveButton primary"  data-id="{{$post->id}}">
									      		<i class="fa fa-bookmark-o"></i> {{$post->save_count}}
								      		</button>
							      		@else
									      	<button class="button unsaveButton primary" data-id="{{$post->id}}">
									      		<i class="fa fa-bookmark"></i> {{$post->save_count}}
								      		</button>
							      		@endif
						      		@else
								      	<button class="button primary" data-toggle="loginModal">
								      		<i class="fa fa-folder"></i>
								      		Save
							      		</button>
						      		@endif
						      	@endif
			            	</li>
			            	<li>
			            		<a href="#">
				            		<i class="fa fa-comment-o"></i> {{$post->comment_count}}
							  	</a>
			            	</li>
			            	<li>
								<a href="{{route('user.profile', array('slug' => $post->author->slug))}}">
							        <img src="{{ $post->author->userImage()}}"/>
									{{ $post->author->username}}
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
			<div class="columns medium-12">
				<h3>
			  		{{ $post->title  }}
		  		</h3>
				<small class="momentjs" data-date="{{ $post->created_at}}"></small><small> нийтэлсэн</small>
				@if($post->created_at != $post->updated_at) 
					<small>(</small><small class="momentjs" data-date="{{ $post->updated_at}}"></small> <small>зассан)</small>
				@endif
				@foreach($tags as $tag)
	      			<a href="{{route('tag.showbySlug', array('slug' =>$tag->slug))}}">
			    		<span class="tag">{{$tag->name}} ({{$tag->post_count}})</span>
			    	</a>
		  		@endforeach
			</div>
			<div class="columns medium-9">
				@include('include.status')
				{!! $markdown !!}

			</div>
			<div class="columns medium-3"></div>
		</div>
	</div>
@endsection

	@section('script')
    {!! HTML::script('js/min/highlight.pack.js') !!}
    @if(!empty($user))
	    <script type="text/javascript">
			// enableTab('addcomment');
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
	        // ajaxPagination('{{ url('/post/'. $post->slug .'/comments')}}', 'null', 'comment-content');
	    });
	</script>
@endsection
