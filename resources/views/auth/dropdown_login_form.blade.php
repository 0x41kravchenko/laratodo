<form id="login-form" method="POST" role="form" autocomplete="off">
	@csrf
	<div class="form-group">
		<label for="email">Email</label>
		<input type="text" name="email" tabindex="1" class="form-control" placeholder="Email" value="" autocomplete="off">
	</div>

	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" name="password" tabindex="2" class="form-control" placeholder="Password" autocomplete="off">
	</div>

	<div class="form-group form-errors">
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col-xs-7">
				<input type="checkbox" tabindex="3" id="remember-me">
				<label for="remember-me"> Remember Me</label>
			</div>
				<div class="col-xs-5 pull-right">
					<input type="submit" id="login-submit-button" tabindex="4" class="form-control btn btn-success" value="Log In">
				</div>
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col-lg-12">
				<div class="text-center">
					<a href="/" tabindex="5" class="forgot-password">Forgot Password?</a>
				</div>
			</div>
		</div>
	</div>
</form>
