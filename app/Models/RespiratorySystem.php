<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespiratorySystem extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'patient_id', 'history', 'pneumonia', 'bronchial_asthma', 'tb', 'chest_expansion', 'abnormal_dullness', 'abnormal_auscultatory', 'voice', 'goitre', 'comments'
    ];
}
