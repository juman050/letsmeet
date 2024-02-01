<header class="topbar">
	<div class="container">
		<div class="row">
			<nav class="navbar">
			  <div class="container-fluid">
			    <div class="navbar-header">
			      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span> 
			      </button>
			      <a class="navbar-brand" href="#">LetsMeet</a>
			    </div>
			    <div class="collapse navbar-collapse" id="myNavbar">
			      <ul class="nav navbar-nav navbar-right">
			      	<li class="active"><a href="{{ url('/home') }}">Home</a></li>
			        <li><a href="{{ url('/conversations') }}">Message</a></li> 
			        <li><a href="{{ url('/profile') }}">Profile</a></li> 
			        <li><a href="{{ url('/activity') }}">Activity</a></li> 
			        <li><a href="{{ url('/find-people') }}">Find People</a></li> 
			        <li><a href="{{ url('/logout') }}"><span class="fa fa-log-out"></span> Logout</a></li>
			      </ul>
			    </div>
			  </div>
			</nav>
		</div>
	</div>
</header>