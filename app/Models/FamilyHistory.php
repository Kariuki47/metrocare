<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyHistory extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'patient_id', 'history'
    ];

    protected $casts = [
        'history' => 'array',
    ];
}
