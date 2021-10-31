<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Auth\Events\Registered;
use Inertia\Inertia;

use App\Models\User;
use App\Models\Blog;

class UserController extends Controller
{
    public function list() {
        $users = User::all();
        return Inertia::render('User.List', [
            'users' => $users
        ]);
    }

    public function create() {
        // create user page
        return Inertia::render('User.Create');
    }

    public function store(Request $request) {
        // store user
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        event(new Registered($user));

        return Redirect::route("user.list");
    }

    public function edit(Request $request, User $user) {
        $user_blogs = Blog::where('user_id', $user->id)->get();
        \Debugbar::info($user_blogs);
        // modify user page
        $user_filtered = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role
        ];
        
        return Inertia::render('User', [
            'user' => $user_filtered
        ]);
    }

    public function update(Request $request, User $user) {
        // store user update
        $request->validate([
            'name' => ['required',
                        'string',
                        'max:255'],
            'email' => ['required',
                        'string',
                        'email',
                        'max:255',
                        Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable',
                            'required_with:password_confirmation', 
                            'confirmed', 
                            Rules\Password::defaults()]
            ]);
        
        $user->update($request->only('name', 'email', 'role'));

        if ($request->get('password')) {
            $user->update(['password' => Hash::make($request->get('password'))]);
        }

        return Redirect::route("user.list");
    }

    public function delete(Request $request, User $user) {
        // delete user
        $user_blogs = Blog::where('user_id', $user->id)->get();
        
        foreach ($user_blogs as $user_blog) {
            $user_blog->delete();
        }

        $user->delete();

        return Redirect::route("user.list");
    }
}
