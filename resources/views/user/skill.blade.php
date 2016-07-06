@extends('layouts.main')
	@section('title')
	    Site Name - Site Description
	@endsection
	@section('navbar')
		<div data-sticky-container>
			<div class="title-bar sub-title-bar" data-sticky data-options="marginTop:0;" style="width:100%" data-top-anchor="40" data-sticky-on="small">
				<div class="row column">
			        <div class="sub-menu">
			            <div class="top-bar-right">
			              @include('include.search')
			            </div>
			        </div>
			    </div>
		    </div>
		</div>
	@endsection

	@section('content')
        <div class="row">
			<div class="columns medium-4">
		        @include('include.setting-sidebar')
			</div>
            <div class="columns medium-8">
			    {!! Form::open(['url' => route('user.addskill') ]) !!}
					<div class="white-box">
				  		<div class="row column">
			  				<span class="select">
				                {!! Form::text('tags', null,[
				                    'class'         =>  'input',
				                    'id'			=>	'tags'
				                ]) !!}
	                            <p class="help-text">5 хүртэлх таг оруулна уу.</p>
				            </span>
				        </div>
			        </div>
	                <div class="white-box">
					  	<button class="button success">
					  		<i class="fa fa-save"></i>
					  		Хадгалах
					  	</button>
					</div>
	            {!! Form::close() !!}
            </div>
        </div>
	@endsection

	@section('script')

	    {!! HTML::script('js/min/inputtag.js') !!}
	    {!! HTML::script('js/min/jqueryui.js') !!}
		<script type="text/javascript">
		    var JsonArray = <?php echo $user->tags; ?>;
		    skillAdd();
		</script>
	@endsection
