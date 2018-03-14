
<nav class="navbar navbar-default">
	<div class="container-fluid">
		
		<div class="navbar-header">
			<a class="navbar-brand" href="/">TO-DO List</a>
		</div>
		
		@if(Auth::check())
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<!--<p>Logged in as</p>-->
					<a href="#" class="dropdown-toggle navbar-user-meta" data-toggle="dropdown">Logged in as <span class="navbar-username">{{ Auth::user()->name }} </span> <span class="caret"></span></a>
					<ul class="dropdown-menu dropdown-um" role="menu">
						<li><a href="#" id="logout-button" data-csrf-token="{{ csrf_token() }}"><i class="glyphicon glyphicon-off"></i> Logout</a></li>
					</ul>
				</li>
			<ul>
		@else
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="" id="register-dropdown" class="dropdown-toggle" data-toggle="dropdown">Register <span class="caret"></span></a>
					<ul class="dropdown-menu dropdown-lr" role="menu">
						<div class="col-lg-12">
							<div class="text-center"><h3><b>Register</b></h3></div>
								@include('auth.dropdown_register_form')
						</div>
					</ul>
				</li>
				<li class="dropdown">
					<a href="" id="login-dropdown" class="dropdown-toggle" data-toggle="dropdown">Log In <span class="caret"></span></a>
					<ul class="dropdown-menu dropdown-lr" role="menu">
						<div class="col-lg-12">
							<div class="text-center"><h3><b>Log In</b></h3></div>
								@include('auth.dropdown_login_form')
						</div>
					</ul>
				</li>
			</ul>
		@endif
		
	</div>
</nav>

