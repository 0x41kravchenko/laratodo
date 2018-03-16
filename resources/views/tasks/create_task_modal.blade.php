<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title">Create New Task</h4>
		</div>
		<div class="modal-body">
			<form id="create-task-form">
				@csrf
				<div class="form-group">
					<label>Task</label>
					<input name="title" type="text" class="form-control" placeholder="Task Title">
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea name="description" class="form-control" placeholder="Task description"></textarea>
				</div>
				<div class="form-group expiration-inputs">
					<div class="row">
					<div class="col-sm-1 checkbox-wrapper">
						<input type="checkbox" name="set-expiration" id="set-expiration">
					</div>
					<div class="col-sm-7">
						<label class="disabled-input">Expiration date</label>
						<input type="datetime-local" step="60" name="expiration-datetime" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" disabled>
					</div>
					<div class="col-sm-4">
						<label class="disabled-input">UTC offset (timezone)</label>
						<input type="text" name="expiration-datetime-tz" value="+00:00" class="form-control" disabled>
					</div>
					</div>
				</div>
				<div class="form-group categories-select-input">
					@include('categories.categories_select_input')
				</div>
				<div class="form-group form-errors">
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">
				Close
			</button>
			<button id="create-task-button" type="button" class="btn btn-primary">
				Save changes
			</button>
		</div>
	</div>
</div>

