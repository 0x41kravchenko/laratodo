<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Task;

class MainController extends Controller
{
    public function index() {
			$categories = Category::all();
			$tasks = Task::all();
			return view('index', compact('categories', 'tasks'));
    }
}
