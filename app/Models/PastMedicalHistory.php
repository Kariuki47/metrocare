<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastMedicalHistory extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $casts = [
        'chronic_illness' => 'array',
    ];

    protected $fillable = [
        'patient_id', 'admission', 'chronic_illness', 'medical_treatment', 'medical_treatment_which', 'medical_treatment_when', 'blood_transfusion'
    ];
}
