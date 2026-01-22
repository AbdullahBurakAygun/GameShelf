<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class AdminUserService
{
    public function searchAndPaginate(?string $search, int $perPage = 10): LengthAwarePaginator
    {
        return User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function createUser(array $validated): User
    {
        return User::create($validated);
    }

public function updateUser(User $user, array $validated): void
{
    if (empty($validated['password'])) {
        unset($validated['password']);
    }

    $user->update($validated);
}


    public function deleteUser(User $user, int $currentUserId): void
    {
        if ($user->id === $currentUserId) {
           
            throw new \DomainException('You cannot delete your own account.');
        }

        $user->delete();
    }
}
