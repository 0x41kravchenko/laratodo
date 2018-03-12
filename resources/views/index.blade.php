@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-3">
			<div class="panel panel-default">
				<div class="panel-heading lead clearfix" style="font-size: 16px; line-height: 200%; vertical-align: middle;">
					Categories
					<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#create-category-modal">
						Create New Category
					</button>
				</div>
				<div class="categories-list panel-body list-group ">
					@include('categories.categories_list')
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-9">
			<div class="panel panel-default">
				<div class="panel-heading lead clearfix">
					Tasks
					<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#create-task-modal">
						Create New Task
					</button>
				</div>
				<div class="tasks-list panel-body">
					@include('tasks.tasks_list')
				</div>
			</div>
		</div>
	</div>
@endsection
