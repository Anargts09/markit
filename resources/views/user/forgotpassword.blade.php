@extends('layouts.main')
    @section('title')
        Site Name - Site Description
    @endsection

    @section('navbar')
        </div>
    @endsection

    @section('content')
        <div class="row">
            <div class="columns medium-6 medium-push-3">
                <fieldset class="field-form">
                    @include('include.status')
                    <div >
                        <h4>Нууц үг дахин авах</h4>
                        {!! Form::open(['url' => route('auth.password-post')]) !!}
                            {!! csrf_field() !!}

                            <div class="control has-icon">
                                {!! Form::email('email', null,[
                                    'class'         =>  'input',
                                    'placeholder'   =>  'Your email, e.g. startup@qiita.mn',
                                    'required'
                                ]) !!}
                            </div>

                            <button type="submit" class="button primary">Имэйлээр нууц үг солих линк авах</button>

                        {!! Form::close() !!}
                    </div>
                </fieldset>
            </div>
        </div>
    @endsection

    @section('script')
    @endsection