<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialHistory extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'patient_id', 'marital_status', 'no_children', 'profession', 'units_alcohol', 'no_cigarettes', 'duration_smoking', 'menstrual_cycle', 'contraception'
    ];
}
