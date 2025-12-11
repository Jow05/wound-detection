<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Admin Dashboard
    public function admin()
    {
        return view('dashboard.admin');
    }

    // Doctor Dashboard
    public function doctor()
    {
        return view('dashboard.doctor');
    }

    // Patient Dashboard
    public function patient()
    {
        return view('dashboard.patient');
    }
}