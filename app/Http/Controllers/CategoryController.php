<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Task;

class CategoryController extends Controller
{
    
    public function __construct() {
			$this->middleware('auth')->except(['index']);
    }
    
    public function index() {
			$categories = Category::all();
			$tasks = Task::all();
			return view('categories.categories_list', compact('categories', 'tasks'));
			
    }
    
    public function store() {
			$this->validate(request(), [
				'name' => 'required|min:2|max:16',
				'color' => 'required|regex:/^#[0-9a-fA-F]{6}$/'
			]);
			
			$newCat = Category::create(request(['name', 'color']));
			return $newCat->id;
    }
    
    public function update(Category $category) {
			$this->validate(request(), [
				'id' => 'exists:categories,id',
				'name' => 'required|min:2|max:16',
				'color' => 'required|regex:/^#[0-9a-fA-F]{6}$/'
			]);
			$category->update(request(['name', 'color']));
			return 'Done!';
    }
    
    public function destroy(Category $category) {
			$category->delete();
			if (count($category->tasks)) { // if deleted category had tasks set their category_id's to 0
				foreach($category->tasks as $task) {
					$task->update(['category_id' => 0]);
				}
			}
			return 'Done!';
    }
    
    public function getSelectInput() {
			$categories = Category::all();
			return view('categories.categories_select_input', compact('categories'));
    }
}
