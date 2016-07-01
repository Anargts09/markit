@extends('layouts.main')
    @section('title')
        Site Name - Site Description
    @endsection

    @section('navbar')
        </div>
    @endsection

    @section('content')
        <div class="row">
            <div class="login-form">
                <div class="column medium-3">
                    <fieldset class="field-form">
                        @include('include.status')
                        <div >

                            {!! Form::open(['url' => route('auth.password-post')]) !!}
                                {!! csrf_field() !!}

                                <div class="control has-icon">
                                    {!! Form::email('email', null,[
                                        'class'         =>  'input',
                                        'placeholder'   =>  'Your email, e.g. startup@qiita.mn',
                                        'required'
                                    ]) !!}
                                    <i class="fa fa-envelope"></i>
                                </div>

                                    <button type="submit" class="button is-primary">Имэйлээр нууц үг солих линк авах</button>

                            {!! Form::close() !!}
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        {!! HTML::script('js/minmain.js') !!}
    @endsection