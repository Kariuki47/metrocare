<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentralNervousSystem extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $fillable = [
        'patient_id', 'history', 'sequellae', 'papillary', 'nervous_dysfunction', 'neurological_abnormalities', 'mental_health', 'headaches', 'comments'
    ];
}
