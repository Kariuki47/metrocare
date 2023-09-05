<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardiovascularSystem extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'patient_id', 'blood_pressure', 'breath', 'palp', 'history', 'heart_enlarged', 'heart_sounds', 'cadiac_murmurs', 'murmur_pathological', 'murmur_irradiate', 'maximal_intensity', 'abdominal_aorta_dilated', 'peripheral_pulses', 'arterial_bruits', 'comments'
    ];
}
