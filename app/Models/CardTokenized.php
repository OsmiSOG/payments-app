<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardTokenized extends Model
{
    use HasFactory;

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
