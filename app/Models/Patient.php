<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\County;

class Patient extends Model
{
    use HasFactory;


    protected $primaryKey = "id";

    protected $fillable = [
        'name', 'sex', 'id_no', 'dob', 'email', 'county', 'phone', 'physician', 'physician_tel', 'longevity', 'disability', 'comments', 'health', 'recommendation', 'conclusion'
    ];

    protected $appends = ['sex_name', 'county_name', 'abbr_name'];

    public function getSexNameAttribute()
    {
        return ucfirst($this->attributes['sex']);
    }

    public function getCountyNameAttribute()
    {
        $county = County::find((int)$this->attributes['county']);
        if ($county) {
            return $county->name;
        } else {
            return '';
        }
    }

    public function getAbbrNameAttribute()
    {
        $name = $this->attributes['name'];
        $name_array = explode(' ', trim($name));

        $firstWord = $name_array[0];
        $lastWord = $name_array[count($name_array) - 1];

        return $firstWord[0] . "" . $lastWord[0];
    }

    public function delete(): ?bool
    {
        $this->respiratorySystem()->delete();
        $this->bloodPressure()->delete();
        $this->cardiovascularSystem()->delete();
        $this->centralNervousSystem()->delete();
        $this->familyHistory()->delete();
        $this->gastrointestinalSystem()->delete();
        $this->generalAppearance()->delete();
        $this->genitalUrinarySystem()->delete();
        $this->pastMedicalHistory()->delete();
        $this->sensoryOrgan()->delete();
        $this->skeletalSystem()->delete();
        $this->skinTeguments()->delete();
        $this->socialHistory()->delete();

        return parent::delete();
    }

    public function respiratorySystem()
    {
        return $this->hasOne(RespiratorySystem::class, 'patient_id', 'id');
    }

    public function bloodPressure()
    {
        return $this->hasOne(BloodPressure::class, 'patient_id', 'id');
    }

    public function cardiovascularSystem()
    {
        return $this->hasOne(CardiovascularSystem::class, 'patient_id', 'id');
    }

    public function centralNervousSystem()
    {
        return $this->hasOne(CentralNervousSystem::class, 'patient_id', 'id');
    }

    public function familyHistory()
    {
        return $this->hasOne(FamilyHistory::class, 'patient_id', 'id');
    }

    public function gastrointestinalSystem()
    {
        return $this->hasOne(GastrointestinalSystem::class, 'patient_id', 'id');
    }

    public function generalAppearance()
    {
        return $this->hasOne(GeneralAppearance::class, 'patient_id', 'id');
    }

    public function genitalUrinarySystem()
    {
        return $this->hasOne(GenitoUrinarySystem::class, 'patient_id', 'id');
    }

    public function pastMedicalHistory()
    {
        return $this->hasOne(PastMedicalHistory::class, 'patient_id', 'id');
    }

    public function sensoryOrgan()
    {
        return $this->hasOne(SensoryOrgan::class, 'patient_id', 'id');
    }

    public function skeletalSystem()
    {
        return $this->hasOne(SkeletalSystem::class, 'patient_id', 'id');
    }

    public function skinTeguments()
    {
        return $this->hasOne(SkinTeguments::class, 'patient_id', 'id');
    }
    
    public function socialHistory()
    {
        return $this->hasOne(SocialHistory::class, 'patient_id', 'id');
    }
}
