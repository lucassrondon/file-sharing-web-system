<?php

namespace App\Models;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InstitutionType extends Model
{
    use HasFactory;

    public function institutions()
    {
        return $this->hasMany(Institution::class);
    }
}
