<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkinTeguments extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'patient_id', 'jaundice_cyanosis', 'skin_eruption', 'lymphadenopathy', 'scars_tattoos', 'xanthomata', 'comments'
    ];
}
