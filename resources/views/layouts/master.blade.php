<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>To-Do List</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="css/theme.css">
	</head>
	<body>
		<div class="container">
			
			<!-- NAVBAR START -->
				@include('layouts.nav')
			<!-- NAVBAR END -->
			
			<!-- CONTENT START -->
				@yield('content')
			<!-- CONTENT END -->
			
		</div>
		
		<!-- CREATE CATEGORY MODAL START -->
			<div id="create-category-modal" class="modal fade" tabindex="-1" role="dialog">
				@include('categories.create_category_modal')
			</div>
		<!-- CREATE CATEGORY MODAL END -->
		
		<!-- EDIT CATEGORY MODAL START -->
			<div id="edit-category-modal" class="modal fade" tabindex="-1" role="dialog">
				@include('categories.edit_category_modal')
			</div>
		<!-- EDIT CATEGORY MODAL END -->
		
		<!-- CREATE TASK MODAL START -->
			<div id="create-task-modal" class="modal fade" tabindex="-1" role="dialog">
				@include('tasks.create_task_modal')
			</div>
		<!-- CREATE TASK MODAL END -->
		
		<!-- EDIT TASK MODAL START -->
			<div id="edit-task-modal" class="modal fade" tabindex="-1" role="dialog">
				@include('tasks.edit_task_modal')
			</div>
		<!-- EDIT TASK MODAL END -->
		
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<!--
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
-->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script src="js/script.js"></script>
	</body>
</html>
