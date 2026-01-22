<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\AdminUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly AdminUserService $service
    ) {}

    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = $this->service->searchAndPaginate($search, 10);

        return view('admin.users.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users'],
            'password' => ['required','string','min:8','confirmed'],
            'role' => ['required','in:admin,user'],
            'status' => ['nullable','in:active,inactive'],
        ]);

        $this->service->createUser($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users,email,' . $user->id],
            'password' => ['nullable','string','min:8','confirmed'],
            'role' => ['required','in:admin,user'],
            'status' => ['nullable','in:active,inactive'],
        ]);

        $this->service->updateUser($user, $validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        try {
            $this->service->deleteUser($user, auth()->id());
            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully.');
        } catch (\DomainException $e) {
            return redirect()->route('admin.users.index')
                ->with('error', $e->getMessage());
        }
    }
}
