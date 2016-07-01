@if (count($errors) > 0)
    <div class="callout {{ Session::get('status') }}" data-closable>
        @foreach ($errors->all() as $n=> $error)
            <p>{{ ($n+1) }}. {{ $error }}</p>
        @endforeach
        <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (Session::has('message'))
	<div class="callout small {{ Session::get('status') }}" data-closable>
		<p>{{ Session::get('message') }}</p>
        <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
            <span aria-hidden="true">&times;</span>
        </button>
	</div>
@endif