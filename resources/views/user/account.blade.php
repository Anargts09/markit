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
                @include('include.status')
                {!! Form::open(['url' => route('user.post-editaccount')]) !!}
		            <p class="lead small-lead">Profile image</p>
				  	<div class="white-box">
				  		<div class="row">
				  			@if(!empty($user->provider))
				  				<div class="columns small-3 text-center">
									{!! Form::radio('avatar_type', '1', $user->avatar_type == '1' ? 'true' : '', ['id'=>'avatar1']) !!}
									<label for="avatar1">
									    {!! HTML::image($user->avatar, $user->slug, array('class' => '')) !!}
								    </label>
									<p class="help-text">{{$user->provider}}</p>
								</div>
				  			@endif
					  		<div class="columns small-3 text-center">
								{!! Form::radio('avatar_type', '2', $user->avatar_type == '2' ? 'true' : '', ['id'=>'avatar2']) !!}
								<label for="avatar2">
									{!! HTML::image(Gravatar::src($user->email), $user->slug, array('class' => '')) !!}
							    </label>
								<p class="help-text">
									Gravatar
									<a href="https://gravatar.com" target="_blank" class="icon is-small">
										<i class="fa fa-link"></i>
									</a>
								</p>
							</div>
							<div class="columns small-3 text-center">
								{!! Form::radio('avatar_type', '3', $user->avatar_type == '3' ? 'true' : '', ['id'=>'avatar3']) !!}
						    	<?php
									$img = Image::make(file_get_contents(Avatar::create($user->slug)->toBase64()));
									$img->encode('png');
									$type = 'png';
									$base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
								?>
								<label for="avatar3">
									<img src="{!! $base64 !!}">
							    </label>
								<p class="help-text">Avatar</p>
							</div>
							<div class="columns small-3 text-center">
								{!! Form::radio('avatar_type', '4', $user->avatar_type == '4' ? 'true' : '', ['id'=>'avatar4']) !!}
								<label for="avatar4">
									{!! HTML::image($user->avatar1, $user->slug, array('class' => '')) !!}
							    </label>
								<p class="help-text">
									Image Upload
									<a href="{{ route('user.get-imageupload') }}" class="icon is-small">
										<i class="fa fa-upload"></i>
									</a>
								</p>
							</div>
				  		</div>
						<p class="help-text">

				  			Gravatar дээрх зургаа өөрчилсөн тохиолдолд 5 минут орчимын дараа өөрчилөгдөнө.
						</p>
						<p class="help-text">
							GitHub болон Twitter дээр профайл зургаа сольсон бол нэг удаа гараад орно уу.
				  		</p>
					</div>
		            <p class="lead small-lead">Username</p>
					<div class="white-box">
				  		<div class="row column">
					  		{!! Form::text('username', $user->username,[
                                'class'         =>  'input',
                                'placeholder'   =>  'Хэрэглэгчийн нэр'
                            ]) !!}
				  		</div>
					</div>
		            <p class="lead small-lead">Userslug</p>
					<div class="white-box">
				  		<div class="row column">
					  		{!! Form::text('slug', $user->slug,[
                                'class'         =>  'input',
                                'disabled'		=> 	'disabled',
                                'placeholder'   =>  'Хэрэглэгчийн нэр'
                            ]) !!}
                            <p class="help-text">Одоогоор солих боломжгүй</p>
				  		</div>
					</div>
		            <p class="lead small-lead">Language</p>
					<div class="white-box">
				  		<div class="row column">
			  				<span class="select">
						  		{!! Form::select('user_language', [
								   'en' => 'English',
								   'mn' => 'Монгол хэл'], $user->user_language
								) !!}
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

				<div class="menu">
				  	<p class="menu-heading has-icon is-danger">
				  		<i class="fa fa-trash"></i>
				    	<span>Delete Account</span>
				  	</p>
				  	<div class="box">
				  		<p>
				  			Устгасан хэрэглэгчийн мэдээллийг сэргээх боломжгүйг анхаарна уу.
				  		</p>
				  		<br>
				  		<p>
					  		<a class="button is-danger is-outlined" href="#">Устгах</a>
				  		</p>
				  	</div>
				</div>
            </div>
        </div>
	@endsection

	@section('script')
	@endsection
