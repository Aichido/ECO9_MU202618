<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRatingRequest extends FormRequest
{
    public function authorize()
    {
        // user_id est injecté par le middleware ValidateJWT
        return !is_null($this->user_id);
    }

    public function rules()
    {
        return [
            'note'       => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'note.required' => 'La note est obligatoire.',
            'note.min'      => 'La note doit être comprise entre 1 et 5.',
            'note.max'      => 'La note doit être comprise entre 1 et 5.',
        ];
    }
}