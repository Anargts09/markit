@extends('layouts.main')
	@section('title')
	    Site Name - Site Description
	@endsection
	@section('navbar')
			<div class="title-bar sub-title-bar">
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
                @include('include.status')
                {!! Form::open(['url' => route('user.post-editprofile')]) !!}
		            <p class="lead small-lead"><i class="fa fa-user"></i> Name</p>
				  	<div class="white-box">
				  		<div class="row">
				  			<div class="columns medium-6">
							  	{!! Form::text('first_name', $user->first_name,[
                                    'class'         =>  'input',
                                    'placeholder'   =>  'First Name'
                                ]) !!}
				  			</div>
				  			<div class="columns medium-6">
							  	{!! Form::text('last_name', $user->last_name,[
                                    'class'         =>  'input',
                                    'placeholder'   =>  'Last Name'
                                ]) !!}
				  			</div>
				  		</div>
					</div>
					<p class="lead small-lead"><i class="fa fa-link"></i> Website/Blog</p>
					<div class="white-box">
				  		<div class="row">
				  			<div class="columns medium-12">
				  				{!! Form::text('webblog', $user->webblog,[
                                    'class'         =>  'input',
                                    'placeholder'   =>  'URL'
                                ]) !!}
				  			</div>
				  		</div>
					</div>
					<p class="lead small-lead"><i class="fa fa-building-o"></i> Organization</p>
					<div class="white-box">
				  		<div class="row">
				  			<div class="columns medium-12">
				  				{!! Form::text('company', $user->company,[
                                    'class'         =>  'input',
                                    'placeholder'   =>  'Organization'
                                ]) !!}
				  			</div>
				  		</div>
					</div>
					<p class="lead small-lead">Description</p>
					<div class="white-box">
				  		<div class="row">
				  			<div class="columns medium-12">
                                {!! Form::textarea('bio', $user->bio, [
                                	'class' => 'textarea',
                                    'placeholder'   =>  'Write a short description of you'
                                ]) !!}
                                <p class="help-text">300 үсгэнд багтаана уу.</p>
				  			</div>
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
	@endsection
