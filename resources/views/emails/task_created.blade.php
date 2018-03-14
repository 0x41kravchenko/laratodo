<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Template title</title>
	</head>
	<body>
		<h1>New task was created!</h1>
		
		<span><b>Task title:</b> {{ $task->title }}</span><br>
		
		@if (!is_null($task->description))
			<span><b>Task description:</b> {{ $task->description }}</span><br>
		@endif
		
		@if (!is_null($task->category))
			<span><b>Task category:</b> {{ $task->category }}</span><br>
		@endif
		
		<span><b>Task expiration date:</b> </span><br>
	</body>
</html>
