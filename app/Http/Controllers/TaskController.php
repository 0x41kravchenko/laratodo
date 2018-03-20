<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Jobs\SendNotificationEmail;
use App\Mail\TaskCreatedEmail;
use Carbon\Carbon;

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
		
		public function store(Request $request) {
			
			if ($request->has('set-expiration')) {
						
				$this->validate($request, [
					'title' => 'required|min:2|max:64',
					'category_id' => 'required|integer', // Todo later: check if exists in database or equals 0;
					'expires_at' => 'date|after_or_equal:now'
				]);				
				
				$currentTime = Carbon::now();
				$expires = Carbon::parse($request['expires_at']);
				
				if ($expires->copy()->subDay() > $currentTime) {
					$request['expr_tmrw_email_queued'] = false;
					
				} elseif ($expires->copy()->subDay() < $currentTime && $currentTime < $expires) {
						$request['expr_tmrw_email_queued'] = true;
				}
				
			} else {
			
					$this->validate($request, [
						'title' => 'required|min:2|max:64',
						'category_id' => 'required|integer', // Todo later: check if exists in database or equals 0;
					]);
					
					$request['expr_tmrw_email_queued'] = false;
					$request['expires_at'] = null;
			
			}
			
			$task = new Task( $request->only(['title', 'description', 'category_id', 'expr_tmrw_email_queued', 'expires_at']) );
			$created_task = auth()->user()->createTask( $task );
			SendNotificationEmail::dispatch( $created_task, new TaskCreatedEmail($created_task) );
			return 'Done!';
		}
		
		public function update(Request $request, Task $task) {
			
			if ($request->has('edit-expiration')) {
				
				$this->validate($request, [
					'id' => 'exists:tasks,id',
					'title' => 'required|min:2|max:64',
					'category_id' => 'required|integer', // Todo later: check if exists in database or equals 0;
					'expires_at' => 'date|after_or_equal:now'
				]);
				
				$currentTime = Carbon::now();
				$expires = Carbon::parse($request['expires_at']);
				
				if ($expires->copy()->subDay() > $currentTime) {
					$request['expr_tmrw_email_queued'] = false;
					$request['is_expired'] = false;
					
				} elseif ($expires->copy()->subDay() < $currentTime && $currentTime < $expires) {
						$request['expr_tmrw_email_queued'] = true;
						$request['is_expired'] = false;
				}
								
			} else {
				
				$this->validate($request, [
					'id' => 'exists:tasks,id',
					'title' => 'required|min:2|max:64',
					'category_id' => 'required|integer' // Todo later: check if exists in database or equals 0;
				]);
				$request['expr_tmrw_email_queued'] = false;
				$request['is_expired'] = false;
				$request['expires_at'] = null;
				
			}
			
			$task->update($request->only(['title', 'description', 'category_id', 'expr_tmrw_email_queued', 'is_expired', 'expires_at']));
			
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
