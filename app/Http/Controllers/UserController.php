<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\FilterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

final class UserController extends Controller
{
    public function __invoke(FilterUserRequest $request)
    {
        $users = User::query()
            ->when($request->name, function ($query) use ($request) {
                $query->where('name', 'LIKE', "%$request->name%");
            })
            ->whereNot('id', Auth::id())
            ->paginate(6);

        return Inertia::render('Users', [
            'users' => $users
        ]);
    }
}
