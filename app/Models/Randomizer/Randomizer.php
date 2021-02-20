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
        'user_id',
        'name',
    ];

    protected $cast = [
        'inputs' => 'array',
        'results' => 'array',
        "created_at" => 'datetime',
    ];

    public $preserveKeys = true;
}
