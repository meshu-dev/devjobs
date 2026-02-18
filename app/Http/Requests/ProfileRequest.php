<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $minSalaryLimit = config('users.min_salary_limit');
        $maxSalaryLimit = config('users.max_salary_limit');

        return [
            'name'       => 'required|string|min:2|max:100',
            'min_salary' => "required|integer|between:$minSalaryLimit,$maxSalaryLimit|lt:max_salary",
            'max_salary' => "required|integer|between:$minSalaryLimit,$maxSalaryLimit|gt:min_salary",
        ];
    }
}
