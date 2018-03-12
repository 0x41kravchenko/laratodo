<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title">Edit Category</h4>
		</div>
		<div class="modal-body">
			<form id="edit-category-form">
				@csrf
				@method('PUT')
				<input name="id" type="hidden">
				<div class="form-group">
					<label>Category name</label>
					<input name="name" type="text" class="form-control" placeholder="Category Name">
				</div>
				<div class="form-group">
					<label>Category color</label>
					<input name="color" type="color" class="form-control" value="#18d07f">
				</div>
				<div class="form-group form-errors">
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">
				Close
			</button>
			<button id="edit-category-button" type="button" class="btn btn-primary">
				Save changes
			</button>
		</div>
	</div>
</div>

