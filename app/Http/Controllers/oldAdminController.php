<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{



    public function profile()
    {
        $admin = Auth::user();
        return view('admin.profile.index', compact('admin'));
    }
}