<?php

namespace App\Rules;

use Closure;
use App\Models\Book;
use Illuminate\Contracts\Validation\ValidationRule;

class BookRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $book = Book::findOrFail($value);
        if($book->num_off_copies == 0)
        {
            $fail("Book '$book->title' is out of stock" );
        }
        
    }
}
