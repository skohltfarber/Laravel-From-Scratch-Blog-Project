<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Validation\ValidationException;

class SessionsController extends Controller
{

    public function destroy()
    {
        // ddd('destroy');
        auth()->logout();
        session_destroy();

        return redirect('/')->with('success', 'Goodbye!');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required|min:7|max:255',
        ]);

        // log the user in.
        if (! auth()->attempt($attributes)) {

            throw ValidationException::withMessages([
                'email'=>'Your provided credentials could not be verified.'
            ]);
           
        }

        session()->regenerate();
        // Regenerate Session Information to gurad againast Session Fixation.
        
        return redirect('/')->with('success', 'Your account has been created.');
    }
 
    public function create()
    {
        return view('sessions.create');
    }
}
