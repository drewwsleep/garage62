<?php

namespace App\Http\Controllers;

use App\Models\Car;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::query()
            ->with('carModel')
            ->orderByDesc('id')
            ->get();

        return response(view('partials.car-list', compact('cars'))->render());
    }
}
