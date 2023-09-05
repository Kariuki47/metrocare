<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GastrointestinalSystem extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'patient_id', 'history','abnormalities_mouth', 'abnormalities_abdomen', 'hepatomegaly', 'splenomegaly', 'abnormalities_hernial_orifices', 'signs_haemorrhoids', 'comments'
    ];
}
