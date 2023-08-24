<?php

namespace App\Models;

use App\Models\Document;
use App\Models\InstitutionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Institution extends Model
{
    use HasFactory;

    public function institutionType()
    {
        return $this->belongsTo(InstitutionType::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
