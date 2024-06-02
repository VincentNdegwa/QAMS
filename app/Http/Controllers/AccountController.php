<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function openAccount()
    {
        return Inertia::render("Account", []);
    }
}
