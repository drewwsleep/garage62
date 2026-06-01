<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'car_models';

    public $timestamps = false;

    protected $fillable = [
        'brand',
        'model',
    ];
}
