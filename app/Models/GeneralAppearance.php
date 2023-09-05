<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralAppearance extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'patient_id', 'height', 'waist', 'weight', 'hip', 'bmi', 'age', 'morphological', 'mutations', 'stigmata', 'state_health', 'comments'
    ];
}
