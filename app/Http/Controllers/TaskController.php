<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Mail\MailNotification;

class TaskController extends Controller
{

		public function __construct() {
			$this->middleware('auth')->except(['index']);
		}

		public function index() {
			$categoryId = request('cat');
			$tasks = [];
			if (is_null($categoryId) || $categoryId == "all") {
				$tasks = Task::all();
			} elseif ( auth()->check() && $categoryId == "my-tasks") {
					$tasks = auth()->user()->tasks;
				} elseif (is_numeric($categoryId)) {
						$tasks = Task::where('category_id', $categoryId)->get();
				}
			return view('tasks.tasks_list', compact('tasks'));
		}
		
		public function store() {
			$this->validate(request(), [
				'title' => 'required|min:2|max:64',
				'category_id' => 'required|integer' // Todo later: check if exists in database or equals 0;
			]);
			//Task::create(request(['title', 'description','category_id']));
			$task = new Task(request(['title', 'description','category_id']));
			auth()->user()->createTask( $task );
			\Mail::to(auth()->user())->send( new MailNotification($task) );
			return 'Done!';
		}
		
		public function update(Task $task) {
			$this->validate(request(), [
				'id' => 'exists:tasks,id',
				'title' => 'required|min:2|max:64',
				'category_id' => 'required|integer' // Todo later: check if exists in database or equals 0;
			]);
			$task->update(request(['title', 'description', 'category_id']));
			return 'Done!';
		}
		
		public function setStatus(Task $task) {
			$this->validate(request(), [
				'completed' => 'required|boolean'
			]);
			$task->update(request(['completed']));
			return 'Done!';
		}
		
    public function destroy(Task $task) {
			$task->delete();
			return 'Done!';
    }
}
