<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

final class UserController extends Controller
{
    public function __invoke()
    {
        $users = User::query()
            ->whereNot('id', Auth::id())
            ->paginate(6);

        return Inertia::render('Users', [
            'users' => $users
        ]);
    }
}
