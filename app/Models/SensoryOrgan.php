<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensoryOrgan extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'patient_id', 'eyes', 'visual_acuity', 'b_correction', 'a_correction', 'ears', 'comments'
    ];
}
