<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'subject_name',
    ];

    use HasFactory;

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public static function getSubjectId(string $subjectName)
    {

    $subject = Subject::create([
        'subject_name' => $subjectName,
    ]);

    return $subject->id;

    }
}
