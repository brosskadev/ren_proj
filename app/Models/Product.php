<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['article', 'name', 'status', 'attributes'];

    protected $casts = [
        'attributes' => 'array',
    ];
}