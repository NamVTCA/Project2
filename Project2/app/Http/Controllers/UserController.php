<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected $messages = [
        'name.regex' => 'Tên chỉ được chứa chữ cái và khoảng trắng',
        'name.not_regex' => 'Tên không được chứa số',
        'phone.regex' => 'Số điện thoại chỉ được chứa số',
        'phone.min' => 'Số điện thoại phải có ít nhất 10 số',
        'phone.max' => 'Số điện thoại không được quá 11 số',
    ];

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

    public function edit(User $user)
    {
        try {
            return view('users.edit', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error editing user: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        try {
            return view('users.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error showing user: ' . $e->getMessage());
        }
    }
    
    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            
            // Xử lý upload ảnh
            if ($request->hasFile('img')) {
                $path = $request->file('img')->store('public/users');
                $validated['img'] = Storage::url($path);
            }

            // Hash password
            $validated['password'] = Hash::make($validated['password']);
            
            // Create user
            $user = User::create($validated);

            DB::commit();
            
            return redirect()->route('users.index')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->handleError($e);
        }
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            
            // Xử lý upload ảnh
            if ($request->hasFile('img')) {
                // Xóa ảnh cũ
                if ($user->img && Storage::exists('public/' . str_replace('/storage/', '', $user->img))) {
                    Storage::delete('public/' . str_replace('/storage/', '', $user->img));
                }
                
                // Upload ảnh mới
                $path = $request->file('img')->store('public/users');
                $validated['img'] = Storage::url($path);
            }

            // Remove password from validated data if not provided
            if (empty($validated['password'])) {
                unset($validated['password']);
            } else {
                $validated['password'] = Hash::make($validated['password']);
            }

            // Update user
            $user->update($validated);

            DB::commit();
            
            return redirect()->route('users.index')
                ->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->handleError($e);
        }
    }

    private function handleError(\Exception $e)
    {
        logger()->error('User operation failed: ' . $e->getMessage());
        
        return redirect()->back()
            ->with('error', 'Operation failed: ' . $e->getMessage())
            ->withInput();
    }
}