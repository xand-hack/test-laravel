<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistered;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        $user = User::create($validatedData);

        Mail::to($user->email)->send(new UserRegistered($user));
        

        return response()->json(['message' => 'User created successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        $user = User::findOrFail($id);
        $user->update($validatedData);

        return response()->json(['message' => 'User updated successfully'], 200);
    }
}
