<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

final class DashboardController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Dashboard');
    }
}
