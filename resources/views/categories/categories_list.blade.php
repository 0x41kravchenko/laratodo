<a href="" class="list-group-item active" data-category-id="all">
	<span class="badge">{{ count($tasks) }}</span>
	<span>All tasks</span>
</a>

@if(Auth::check())
<a href="" class="list-group-item" data-category-id="my-tasks">
	<span class="badge">{{ count(Auth::user()->tasks) }}</span>
	<span><b>My tasks</b></span>
</a>
@endif

@foreach($categories as $category)
	<a href="" class="list-group-item" data-category-id="{{ $category->id }}" data-category-color="{{ $category->color }}">
		<span class="badge">{{ count($category->tasks) }}</span>
		@if(Auth::check())
			<div class="tools">
					<i class="glyphicon glyphicon glyphicon-pencil edit-category-icon"></i>
					<i class="glyphicon glyphicon-remove-circle delete-category-icon" data-csrf-token="{{ csrf_token() }}"></i>
			</div>
		@endif
		<span class="category-name"><small class="label" style="background-color: {{ $category->color }}; font-size: 100%">{{ $category->name }}</small></span>
	</a>
@endforeach

