<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends Controller
{

		public function __construct() {
			$this->middleware('guest', ['except' => 'destroy']);
			$this->middleware('auth', ['only' => 'destroy']);
		}

    public function register() {
			
			$this->validate(request(), [
				'name' => 'required',
				'email' => 'required|email|unique:users',
				'password' => 'required|min:4|max:64|confirmed'
			]);
			
			$user = User::create([
				'name' => request('name'),
				'email' => request('email'),
				'password' => Hash::make(request('password'))
			]);
			
			auth()->login($user); // auth() is helper method and == Auth::login(), but Auth class requires 'use' namespace
			
    }
    
    public function login() {
    
			$this->validate(request(), [
				'email' => 'required|email',
				'password' => 'required',
				'remember-me' => 'boolean'
			]);
			
			if (!auth()->attempt(request(['email', 'password']), request('remember-me'))) {				
				// return validation-like error
				return response()->json([
					'errors' => [['Email or password is incorrect, please try again.']]
				], 422);
			}
			
    }
    
    public function destroy() {
			auth()->logout();
    }
    
}
