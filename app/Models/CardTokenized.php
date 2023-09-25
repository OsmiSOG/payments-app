<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardTokenized extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'number',
        'cvv',
        'holder',
        'datetime',
    ];

    protected $hidden = [
        'number',
        'cvv',
        'holder',
        'datetime',
    ];
}
