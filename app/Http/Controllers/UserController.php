<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(User $user): View
    {
        return view('profile', [
            'user' => $user,
            'chirps' => $user->chirps()->with('user')->latest()->paginate(10)->withQueryString(),
            'search' => '',
        ]);
    }

    public function search(Request $request, User $user): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $search = trim($validated['search'] ?? '');

        $chirps = $user->chirps()
            ->with('user')
            ->when($search !== '', fn ($query) => $query->where('message', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('components.chirp-list', compact('chirps', 'search'));
    }
}
