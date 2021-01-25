<?php

namespace App\Models\Randomizer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Randomizer extends Model
{
    use HasFactory;
    protected $fillable = [
        'random_type',
        'inputs',
        'results',
        'user_id'
    ];

    protected $cast = [
        'inputs' => 'array',
        'results' => 'array'
    ];

}
