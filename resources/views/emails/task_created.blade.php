<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Template title</title>
		<style>
			.task-info {
				font-weight: bold;
			}
		</style>
	</head>
	<body>
		<h1>New task was created!</h1>
		<span class="task-info">Task details: </span>
		<ul>
			<li><span class="task-info">title: </span>{{ $task->title }}</li>
			
			@if (!is_null($task->description))
				<li><span class="task-info">description: </span>{{ $task->description }}</li>
			@endif
			
			@if (!is_null($task->category->name))
				<li><span class="task-info">category: </span>{{ $task->category->name }}</li>
			@endif
			
			<li><span class="task-info">expiration date: </span>(date)</li>
		</ul>
	</body>
</html>
