<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_id',
        'name',
        'code',
        'parent_unit_id',
        'heirarchy',
        'heirarchy_json',
        'level',
    ];

    protected $casts = [
        'heirarchy_json' => 'array',
    ];

    public function unitCounts()
    {
        return $this->hasMany(UnitCount::class);
    }
}
