<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenitoUrinarySystem extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'patient_id', 'history', 'genitals_male', 'gynaecomastia', 'genital_sores', 'genitals_female', 'breast', 'menstrual', 'comments'
    ];
}
