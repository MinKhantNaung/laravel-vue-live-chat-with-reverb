<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $users = User::query()
            ->whereNot('id', Auth::id())
            ->paginate(6);

        return Inertia::render('Dashboard', [
            'users' => $users
        ]);
    }
}
