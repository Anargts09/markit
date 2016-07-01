@extends('layouts.editor')
	@section('title')
	    Site Name - Site Description
	@endsection
	@section('navbar')
		    <div class="title-bar sub-title-bar">
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
						<label>
							{!! Form::textarea('inputPane', $edit ? $post->body : null, [
	                        	'class' 		=> 'textarea',
	                        	'id'			=>  'inputPane',
	                            'placeholder'   =>  'Markdown оор бичих'
	                        ]) !!}
	                    </label>
					</div>
					<!-- <div class="columns medium-6">
						<div class="paneHeader">
							<div class="control">
								<span class="select">
									<select id="paneSetting">
										<option value="previewPane">Preview</option>
										<option value="outputPane">HTML Output</option>
									</select>	
								</span>
							</div>
						</div>
						<div class="control">
							{!! Form::textarea('outputPane', null, [
	                        	'class' 		=> 'pane textarea markdown-body',
	                        	'id'			=>  'outputPane',
	                        	'readonly'
	                        ]) !!}
						</div>
						<div id="previewPane" class="pane markdown-body">
							<div class=""><noscript><h2>You'll need to enable Javascript to use this tool.</h2></noscript></div>
						</div>
					</div> -->
				</div>
				<div id="footerPane">
						<p>
							<button class="button primary" type="submit">Save</button>
						</p>
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
