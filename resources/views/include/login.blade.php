<div class="main-login">
    <p class='lead'>Sign in to Codebook to connect with voices and perspectives that matter.</p>

    {!! Form::open(['url' => route('auth.login-post'), 'class' => 'qiita-form' ]) !!}
        <div class="input-group">
            {!! Form::email('email', null,[
                'class'         =>  'input-group-field',
                'placeholder'   =>  'Your email, e.g. user@codebook.mn',
                'required'
            ]) !!}
        </div>
        <div class="input-group">
            {!! Form::password('password',[
                'class'         =>  'input-group-field',
                'placeholder'   =>  'Password',
                'required'
            ]) !!}
            <div class="input-group-button">
                <input type="submit" class="button" value="Нэвтрэх">
            </div>
        </div>
        <div class="span">
            <a href="{{route('auth.password')}}">Нууц үгээ мартсан</a>
        </div>
    {!! Form::close() !!}

    <div class="socialLogin is-text-centered">
        <div class="control">
            <a class="button github small expanded" href="#" onclick="window.open('{{ route('social.redirect', ['provider' => 'github']) }}','')">
                <i class="fa fa-github"></i>
                Github - аар нэвтрэх
            </a>
        </div>
        <div class="control">
            <a class="button twitter small expanded" href="#" onclick="window.open('{{ route('social.redirect', ['provider' => 'twitter']) }}','')">
                <i class="fa fa-twitter"></i>
                Twitter - ээр нэвтрэх
            </a>
        </div>
    </div>
    <a href="{{ route('auth.login') }}">Имэйл хаягаар нэвтрэх</a>
</div>