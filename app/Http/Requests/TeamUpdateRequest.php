<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (request()->isMethod('POST')) {
            return [
                'username' => 'required',
                'email' => 'required|email',
                'group_user' => 'required',
            ];
        }
        return [];
    }

    public function prepareForValidation()
    {
        if ($this->active) {

            $this->merge([
                'email_verified_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
