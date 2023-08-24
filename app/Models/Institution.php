<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Institution extends Model
{
    protected $fillable = [
        'institution_name',
    ];

    use HasFactory;

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /* 
        Gets the id of a institution or create a new 
        institution if it does not exist
    */
    public static function getInstitutionId(string $institutionName)
    {
        $institutions = Institution::where(
            'institution_name', 
            $institutionName
        )->get();
        
        if (count($institutions) > 0) {
            return $institutions[0]->id;
        } else {
            $institution = Institution::create([
                'institution_name' => $institutionName,
            ]);

            return $institution->id;
        }
    }
}
