<a href="{{route('user.profile', array('slug' => $listitem->slug))}}">
    <img src="{{ $listitem->userImage()}}" />
</a>
<a href="{{route('user.profile', array('slug' => $listitem->slug))}}">
	{{ $listitem->username}}
</a>
@if(!empty($user))
	@if($listitem->id != $user->id)
        <button class="button primary clickFollow" data-id="{{$listitem->id}}">
			@if (!$user->followCheck($listitem->id))
			  	<i class="fa fa-user-plus"></i>
			  	<span>Дагах</span>
			@else
			  	<i class="fa fa-check-square"></i>
			  	<span>Дагаж байгаа</span>
			@endif
		</button>
	@endif
@else
	<button class="button primary"  data-toggle="loginModal">
	  	<i class="fa fa-user-plus"></i>
	  	<span>Дагах</span>
	</button>
@endif
<p>	
	{{$listitem->bio}}
</p>
