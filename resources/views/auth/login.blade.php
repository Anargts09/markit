@extends('layouts.main')
    @section('title')
        Site Name - Site Description
    @endsection

    @section('content')
            
        <div class="row">
            <div class="columns medium-5">
                
            </div>
            <div class="column medium-7">
                <fieldset class="field-form">
                    @include('include.status')
                    <div>
			            @include('include.login')
                        <div class="span1">
                            <p>эсвэл <a class="toggle-tab" href="#">имэйл хаягаар бүртгүүлэх</a></p>
                        </div>
                    </div>
                    <div id="tab-register" class="qiita-signup">
                        {!! Form::open(['url' => route('auth.register-post'), 'class' => 'finda-form' ]) !!}
                            <div class="control has-icon">
                                {!! Form::text('username', null,[
                                    'class'         =>  'input',
                                    'placeholder'   =>  'Username',
                                    'required'
                                ]) !!}
                            </div>
                            <div class="control has-icon">
                                {!! Form::email('email', null,[
                                    'class'         =>  'input',
                                    'placeholder'   =>  'Your email, e.g. user@qiita.io',
                                    'required'
                                ]) !!}
                            </div>
                            <div class="control has-icon">
                                {!! Form::email('email_confirmation', null,[
                                    'class'         =>  'input',
                                    'placeholder'   =>  'Email confirm',
                                    'required'
                                ]) !!}
                            </div>
                            <div class="control has-icon">
                                {!! Form::password('password',[
                                    'class'         =>  'input',
                                    'placeholder'   =>  'Password',
                                    'required'
                                ]) !!}
                            </div>
                            
                            <div class="control">
                                <label class="checkbox">
                                    {!! Form::checkbox('agree') !!}
                                    I accept Terms & Conditions and Privacy statement
                                </label>
                            </div>
                            <div class="control">
                                <button type="submit" class="button is-primary">Бүртгүүлэх</button>
                            </div>
                        {!! Form::close() !!}
                        <br>
                        <div class="socialLogin is-text-centered">
                            <div class="control">
                                <a class="button github is-fullwidth" href="#" onclick="window.open('{{ route('social.redirect', ['provider' => 'github']) }}','')">
                                    <i class="fa fa-github"></i>
                                    Github - аар нэвтрэх
                                </a>
                            </div>
                            <div class="control">
                                <a class="button twitter is-fullwidth" href="#" onclick="window.open('{{ route('social.redirect', ['provider' => 'twitter']) }}','')">
                                    <i class="fa fa-twitter"></i>
                                    Twitter - ээр нэвтрэх
                                </a>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    @endsection

    @section('script')

    @endsection