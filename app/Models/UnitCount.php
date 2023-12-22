<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitCount extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'unit_id',
        'created_at',
        'count',
    ];

    protected $casts = [
        'created_at' => 'date',
    ];

}
