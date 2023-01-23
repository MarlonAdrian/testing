<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{

    public function create()
    {
        return view('auth.register');
    }


    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'second_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'personal_phone' => ['required', 'string', 'max:200'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'address' => ['required', 'string', 'max:200'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'second_name' => $request->second_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'personal_phone' => $request->personal_phone,
            'address' => $request->address,
        ]);
        
        $user_role=Role::where('name','client')->first();
        $user_role->users()->save($user);

        event(new Registered($user));

        Auth::login($user);


        return redirect(RouteServiceProvider::HOME);
    }
}
