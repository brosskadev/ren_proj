<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    protected $fillable = ['article', 'name', 'status', 'attributes'];

    protected $casts = [
        'attributes' => 'array',
    ];

    public function getDecodedAttributes(){  
    if (!empty($this->attributes['attributes']) && is_string($this->attributes['attributes'])) {
        $decoded = json_decode($this->attributes['attributes'], true);
        return is_array($decoded) ? $decoded : [];
    }

    return [];
}
}