@extends('layouts.editor')
	@section('title')
	    Site Name - Site Description
	@endsection
	@section('navbar')
		<div data-sticky-container>
			<div class="title-bar sub-title-bar" data-sticky data-options="marginTop:0;" style="width:100%" data-top-anchor="40" data-sticky-on="small">
		    	<div class="row column">
				    <div class="sub-menu">
				        <div class="top-bar-left">
				          	<ul class="menu">
				            	<li>
				              		<a class="first-item" href="#">Write guide</a>
				            	</li>
				            	<li>
				            		<a data-toggle="syntaxPane">
					            		<i class="fa fa-question-circle"></i>
									  	Syntax Guide
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
	@endsection

	@section('content')
		<div class="row expanded">
			<div class="columns small-12">
		        @include('include.status')
	        </div>
	        <label>
				@if($edit)
					{!! Form::open(array('route' => array('post.postEditPost', $post->slug))) !!}
				@else
				    {!! Form::open(['url' => route('post.postnew') ]) !!}
			    @endif
		    </label>
				<div class="columns small-12">
					<label>
						{!! Form::text('title', $edit ? $post->title : null,[
		                    'class'         =>  'input',
		                    'placeholder'   =>  'Гарчиг',
		                    'required'
		                ]) !!}
	                </label>
				</div>
				<div class="columns small-12">
					<label>
						{!! Form::text('tags', null,[
		                    'class'         =>  'input',
		                    'id'			=>	'tags',
		                    'required'
		                ]) !!}
	                </label>
				</div>
				<div class="row expanded">
					<div class="columns small-12">
						<div class="markdown-body">
							<label>
								{!! Form::textarea('inputPane', $edit ? $post->body : null, [
		                        	'class' 		=> 'textarea',
		                        	'id'			=>  'inputPane',
		                            'placeholder'   =>  'Markdown оор бичих'
		                        ]) !!}
		                    </label>
	                    </div>
					</div>
				</div>
				<div class="row expanded">
					<div class="columns small-12">
						<div class="public-checkbox">
							{!! Form::checkbox('status', 1, $edit ? $post->status : null, ['id' => 'checkbox1']) !!}
							<label for="checkbox1">Public?</label>
						</div>
						@if($edit)
							@if($post->status)
								<button class="button primary" type="submit">Post to Public</button>
							@else 
								<button class="button primary" type="submit">Save as draft</button>
							@endif
						@else
							<button class="button primary" type="submit">Save as draft</button>
						@endif
					</div>
				</div>
			{!! Form::close() !!}
		</div>

		<div class="tiny reveal" id="syntaxPane" data-reveal>
		  	<button class="close-button" data-close aria-label="Close reveal" type="button">
		    	<span aria-hidden="true">&times;</span>
		  	</button>
		  	<p>Markdown</p>
		</div>
	@endsection
	
	@section('script')
		@if($edit)
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var taginput = $('#tags_addTag input')
					var JsonArray = <?php echo $post->tags; ?>;
					$.each(JsonArray, function() {
						taginput.val(this.name);
				      	triggerEnter(taginput);
			        });
			    });
			</script>
		@endif
		<script type="text/javascript">
			// enableTab('inputPane');
			window.onbeforeunload = function (e) {
				var message = "This page is asking you to confirm that you want to leave - data you have entered may not be saved.",
			  	e = e || window.event;
			  	// For IE and Firefox
			  	if (e) {
			    	e.returnValue = message;
			  	}
			  	// For Safari
			  	return message;
			};
		</script>
	@endsection
