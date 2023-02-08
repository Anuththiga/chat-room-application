<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function index()
    {
        return view('login');
    }

    function registration()
    {
        return view('registration');

    }

    function logout()
    {

    }

    function validate_registration(Request $request)
    {
        $request->validate([
            'name'      =>      'required',
            'email'     =>      'required|email|unique:users',
            'password'  =>      'required|min:6'
        ]);

        $data = $request->all();
        User::create([
            'name'      =>     $data['name'],
            'email'     =>     $data['email'],
            'password'  =>     Hash::make($data['password'])
        ]);

        return redirect('login')->with('success', 'Registration completed, now you can login...');
    }
}
