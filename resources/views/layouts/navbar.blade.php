<div class="slideUp">
  <div class="title-bar main-menu" id="main-menu">
    <div class="row column">
      <div class="top-bar-left">
        <ul class="menu">
          <li class="logo">
            <a href="{{ route('index') }}">
              <b>Code</b>Book
            </a>
          </li>
        </ul>
      </div>
      <div class="top-bar-right">

        @if(!empty($user))
          <ul class="menu dropdown" data-dropdown-menu>
            <li>
              <a href="{{ route('post.addnew') }}">
                <i class="fa fa-pencil"></i>
                <span class="hide-for-small-only">
                  Write a article
                </span>
              </a>
            </li>
            <li>
              <a href="{{route('user.profile', array('slug' =>$user->slug))}}">
                <img class="header-image" src="{{ $user->userImage() }}" />
                <span>{{$user->username}}</span>
              </a>
            </li>
            <li class="last-item">
              <a href="#">
                <i class="fa fa-chevron-down"></i>
              </a>
              <ul class="menu">
                <li><a href="{{ route('post.addnew') }}">New story</a></li>
                <li><a href="{{route('user.draftItems')}}">Drafts</a></li>
                <li><a href="{{route('user.profile', array('slug' =>$user->slug))}}">Stories</a></li>
                <hr>
                <li><a href="{{ route('saved') }}">Saved Posts</a></li>
                <hr>
                <li>
                  <a href="{{route('user.profile', array('slug' =>$user->slug))}}">
                    Profile
                  </a>
                </li>
                <li><a href="{{ route('user.get-editaccount') }}">Settings</a></li>
                <li><a href="{{ route('user.logout') }}">Sign out</a></li>
              </ul>
            </li>
          </ul>
        @else
          <ul class="menu">
            <li>
              <a data-toggle="loginModal">
                <i class="fa fa-pencil"></i>
                Write a article
              </a>
            </li>
            <li class="last-item">
              <a data-toggle="loginModal">Sign in / Sign up</a>
            </li>
          </ul>
        @endif
      </div>
    </div>
  </div>
</div>