<form id="register-form" method="POST" autocomplete="off">
	@csrf
	<div class="form-group">
		<input type="text" name="name" tabindex="1" class="form-control" placeholder="Username" value="">
	</div>
	
	<div class="form-group">
		<input type="text" name="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
	</div>
	
	<div class="form-group">
		<input type="password" name="password" tabindex="2" class="form-control" placeholder="Password">
	</div>
	
	<div class="form-group">
		<input type="password" name="password_confirmation" tabindex="2" class="form-control" placeholder="Confirm Password">
	</div>
	
	<div class="form-group form-errors">
	</div>
	
	<div class="form-group">
		<div class="row">
			<div class="col-xs-6 col-xs-offset-3">
				<button type="submit" id="register-submit-button" tabindex="4" class="form-control btn btn-info">Register Now</button>
			</div>
		</div>
	</div>
</form>
