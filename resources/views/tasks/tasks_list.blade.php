@if(count($tasks))
	<ul class="todo-list ui-sortable">
		@foreach($tasks as $task)
			<li {!! $task->completed?'class="done"':'' !!} data-task-id="{{ $task->id }}">
			<div>
				<input id="task-status" type="checkbox" {!! $task->completed?'checked="checked"':'' !!} value="">
				<span class="text task-title">{{ $task->title }}</span>
				@if(is_null($task->category))
					<small class="task-category" data-category-id="0"></small>
				@else
					<small class="label task-category" data-category-id="{{ $task->category->id }}" style="background-color: {{ $task->category->color }}">{{ $task->category->name }}</small>
				@endif
				<div class="tools">
					<i class="glyphicon glyphicon glyphicon-pencil edit-task-icon"></i>
					<i class="glyphicon glyphicon-remove-circle delete-task-icon" data-csrf-token="{{ csrf_token() }}"></i>
				</div>
			</div>
			<div class="task-description">{{ $task->description }}</div>
			</li>
		@endforeach
	</ul>
@else
	<div class="alert alert-info alert-message">There are no tasks yet.</div>
@endif
