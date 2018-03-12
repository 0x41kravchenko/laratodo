<label>Category</label>
<select name="category_id" class="form-control">
	<option value="0"> None</option>
	@foreach($categories as $category)
		<option value="{!! $category->id !!}">{{ $category->name }}</option>
	@endforeach
</select>
