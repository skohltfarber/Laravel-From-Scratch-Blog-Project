<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create() 
    {
        return view('register.create');
    }


    public function store() {

        // create the user
        // $attributes = request()->validate([
        //     'name' => ['required','max:255'],
        //     'username' => ['required','min:3','max:255', Rule::unique('users','username')],
        //     'email' => ['required','email','max:255', Rule::unique('users','email')],
        //     'password' => ['required','min:8','max:255']
        // ]);

        $attributes = request()->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:3|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:7|max:255',
        ]);

        $user = User::create($attributes);

        // log the user in.

        auth()->login($user);

        return redirect('/')->with('success', 'Your account has been created.');

    }
}
