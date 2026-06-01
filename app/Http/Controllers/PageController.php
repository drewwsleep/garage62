<?php

namespace App\Http\Controllers;

use App\Models\Car;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function cars()
    {
        $cars = Car::query()
            ->with('carModel')
            ->orderByDesc('id')
            ->get();

        return view('cars', compact('cars'));
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function order()
    {
        return view('order');
    }

    public function makeOrder()
    {
        return view('make_order');
    }
}
