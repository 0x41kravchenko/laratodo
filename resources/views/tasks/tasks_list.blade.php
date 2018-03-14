@if(count($tasks))
	<ul class="todo-list ui-sortable">
		@foreach($tasks as $task)
			<li {!! $task->completed?'class="done"':'' !!} data-task-id="{{ $task->id }}">
			<div>
				@if(Auth::check())
					<input id="task-status" type="checkbox" {!! $task->completed?'checked="checked"':'' !!} value="">
				@else
					<input disabled id="task-status" type="checkbox" {!! $task->completed?'checked="checked"':'' !!} value="" title="Only authenticated users cat mark tasks as completed">
				@endif
				<span class="text task-title">{{ $task->title }}</span>
				@if(is_null($task->category))
					<small class="task-category" data-category-id="0"></small>
				@else
					<small class="label task-category" data-category-id="{{ $task->category->id }}" style="background-color: {{ $task->category->color }}">{{ $task->category->name }}</small>
				@endif
				@if(Auth::check())
					<div class="tools">
						<i class="glyphicon glyphicon glyphicon-pencil edit-task-icon"></i>
						<i class="glyphicon glyphicon-remove-circle delete-task-icon" data-csrf-token="{{ csrf_token() }}"></i>
					</div>
				@endif
			</div>
			<div class="task-bottom">
				@if (is_null($task->description))
					<span class="task-description" style="user-select: none; opacity: 0.3;">No description</span>
				@else
					<span class="task-description">{{ $task->description }}</span>
				@endif
				@if (is_null($task->user))
					<div class="task-user" data-user-id="0"></div>
				@else
					<div class="task-user label label-default" data-user-id="{{ $task->user->id }}"><i class="glyphicon glyphicon-user"></i> {{ $task->user->name }}</div>
				@endif
			</div>
			</li>
		@endforeach
	</ul>
@else
	<div class="alert alert-info alert-message">There are no tasks yet.</div>
@endif
