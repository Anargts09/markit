<ul class="menu vertical setting-menu">
  <li>
    <a class="{{ $active == 'account' ? 'is-active' : '' }}" href="{{ route('user.get-editaccount') }}">
      <i class="fa fa-gear"></i>
      Edit Account
    </a>
  </li>
  <li>
    <a class="{{ $active == 'profile' ? 'is-active' : '' }}" href="{{ route('user.get-editprofile') }}">
      <i class="fa fa-user"></i>
      Edit Profile
    </a>
  </li>
  <li>
    <a class="{{ $active == 'skill' ? 'is-active' : '' }}" href="{{ route('user.get-editskill') }}">
      <i class="fa fa-user"></i>
      User Skills
    </a>
  </li>
</ul>
