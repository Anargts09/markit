
<div data-sticky-container>
	<div class="title-bar sub-title-bar" data-sticky data-options="marginTop:0;" style="width:100%" data-top-anchor="40" data-sticky-on="small">
    	<div class="row column">
		    <div class="sub-menu">
		        <div class="top-bar-left">
		          	<ul class="menu">
		            	<li class="{{ $active == 'posted' ? 'is-active' : ''}}">
		              		<a class="first-item" href="{{ route('user.profile', array('slug' => $showuser->slug)) }}">User's Posts</a>
		            	</li>
			            <li class="{{ $active == 'saved' ? 'is-active' : ''}}">
			              <a href="{{ route('user.savedItems', array('slug' => $showuser->slug)) }}">Saved Posts</a>
			            </li>
				    	<!-- <li class="{{ $active == 'comment' ? 'is-active' : ''}}">
			              <a href="{{ route('user.commentItems', array('slug' => $showuser->slug)) }}">Comments</a>
			            </li> -->
		          	</ul>
		        </div>
		        <div class="top-bar-right">
		        	@include('include.search')
		        </div>
		    </div>
		</div>
	</div>
</div>