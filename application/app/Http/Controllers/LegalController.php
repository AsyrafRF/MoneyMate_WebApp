<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LegalController extends Controller
{
    public function terms(): View
    {
        return view('legal.terms');
    }

    public function agreement(): View
    {
        return view('legal.agreement');
    }

    public function privacy(): View
    {
        return view('legal.privacy');
    }
}