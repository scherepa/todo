<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\Attributes\StopOnFirstFailure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

#[StopOnFirstFailure]
class TaskCreateRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            'title' => (string) Str::of($this->title)->trim()->squish(),
            'completed' => $this->completed === "true"
        ]);
    }

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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['bail', 'required', 'string', 'max:255', 'regex:/^[\p{L}0-9\s.,:()_-]+$/u'],
            'completed' => ['boolean'],
        ];
    }
}
