<?php

namespace App\Rules;

use App\Models\Member;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BorrowedBookRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
        $member = Member::find($value);

        if($member->borrowed_books == 3)
        {
            $fail('You cannot borrow a book because you have already rented 3 books.');
        }

    }
}
