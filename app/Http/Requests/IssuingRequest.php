<?php

namespace App\Http\Requests;

use App\Rules\BookRule;
use App\Rules\BorrowedBookRule;
use Illuminate\Foundation\Http\FormRequest;

class IssuingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'member' => ['required', new BorrowedBookRule],
            'book' => ['required', new BookRule],
        ];
    }
}
