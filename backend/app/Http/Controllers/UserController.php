<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'school' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'avatar' => 'nullable|string|max:255',
            'role' => 'nullable|integer|in:0,1,2', // role phải thuộc [0, 1, 2]
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'school' => $request->school,
            'address' => $request->address,
            'phone' => $request->phone,
            'avatar' => $request->avatar,
            'role' => $request->role ?? 0, // Mặc định là buyer
        ]);

        return response()->json($user, 201);
    }

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'school' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'avatar' => 'nullable|string|max:255',
            'role' => 'nullable|integer|in:0,1,2',
        ]);
        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'school' => $request->school ?? $user->school,
            'address' => $request->address ?? $user->address,
            'phone' => $request->phone ?? $user->phone,
            'avatar' => $request->avatar ?? $user->avatar,
            'role' => $request->role ?? $user->role,
        ]);

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
}
