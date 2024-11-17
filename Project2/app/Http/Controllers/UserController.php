<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $role = $request->get('role', 1);
            $users = User::where('role', $role)->get();
            return view('users.index', compact('users', 'role'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading users: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'name' => 'required|regex:/^[a-zA-Z\s]+$/',
                'id_number' => 'required|numeric',
                'address' => 'required',
                'role' => 'required|in:1,2',
                'status' => 'required',
                'gender' => 'required',
                'phone' => 'required|numeric',
                'img' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($request->hasFile('img')) {
                $path = $request->file('img')->store('public/users');
                $validated['img'] = Storage::url($path);
            }

            $validated['password'] = Hash::make($validated['password']);
            
            $user = User::create([
                'email' => $validated['email'],
                'password' => $validated['password'],
                'name' => $validated['name'],
                'id_number' => $validated['id_number'],
                'address' => $validated['address'],
                'role' => $validated['role'],
                'status' => $validated['status'],
                'gender' => $validated['gender'],
                'phone' => $validated['phone'],
                'img' => $validated['img'] ?? null
            ]);

            DB::commit();
            
            return redirect()->route('users.index')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error creating user: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(User $user)
    {
        try {
            return view('users.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error showing user: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        try {
            return view('users.edit', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error editing user: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'email' => 'required|email|unique:users,email,'.$user->id,
                'name' => 'required|regex:/^[a-zA-Z\s]*$/',
                'id_number' => 'required|numeric',
                'address' => 'required',
                'role' => 'required|in:1,2',
                'status' => 'required',
                'gender' => 'required',
                'phone' => 'required|numeric',
                'img' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($request->hasFile('img')) {
                if ($user->img && Storage::exists('public/' . $user->img)) {
                    Storage::delete('public/' . $user->img);
                }
                $path = $request->file('img')->store('users', 'public');
                $validated['img'] = $path;
            }

            $user->update([
                'email' => $validated['email'],
                'name' => $validated['name'],
                'id_number' => $validated['id_number'],
                'address' => $validated['address'],
                'role' => $validated['role'],
                'status' => $validated['status'],
                'gender' => $validated['gender'],
                'phone' => $validated['phone'],
                'img' => $validated['img'] ?? $user->img
            ]);

            DB::commit();
            
            return redirect()->route('users.index')
                ->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating user: ' . $e->getMessage())
                ->withInput();
        }
    }
}