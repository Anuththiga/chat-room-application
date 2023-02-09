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

    function validate_login(Request $request)
    {
        $request->validate([
            'email'     =>      'required',
            'password'  =>      'required'
        ]);

        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials))
        {
            return redirect('dashboard');
        }

        return redirect('login')->with('success', 'Login details are not valid...');
    }

    function dashboard()
    {
        if(Auth::check())
        {
            return view('dashboard');
        }
        return redirect('login')->with('success', 'You are not allowed to access...');
    }

    function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('login');
    }

    function profile()
    {
        if(Auth::check())
        {
            $data = User::where('id', Auth::id())->get();
            return view('profile', compact('data'));
        }

        return redirect('login')->with('message', 'You are not allowed to access...');
    }

    function profile_validation(Request $request)
    {
        $request->validate([
            'name'      =>  'required',
            'email'     =>  'required|email',
            'user_image'    => 'image|mimes:jpg,png,jpeg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'

        ]);
        $user_image = $request->$hidden_user_image;

        if($request->user_image != '')
        {
            $user_image = time(). '.' . $request->user_image->getClientOriginalExtension();
            $request->user_image->move(public_path('images'), $user_image);
        }
    }
    
}
