<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DocumentValidationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $allowedMimeTypes = [
            'application/pdf',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'text/plain',
            'application/msword',
        ];
        $maximumSize      = 1024333434433;

        if (!in_array($value->getMimeType(), $allowedMimeTypes)) {
            $fail('File type not allowed');
        }
        elseif ($value->getSize() > $maximumSize) {
            $fail('The file is too big');
        }
    }
}
