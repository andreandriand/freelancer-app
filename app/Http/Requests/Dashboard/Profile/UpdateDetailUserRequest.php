<?php

namespace App\Http\Requests\Dashboard\Profile;

use App\Models\DetailUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class UpdateDetailUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "photo" => [
                'nullable',
                'file',
                'max:10240',
            ],
            "role" => [
                'nullable',
                'string',
                'max:75',
            ],
            "contact_number" => [
                'required',
                'max:15',
            ],
            "biography" => [
                'nullable',
                'string',
                "max:5000",
            ]
        ];
    }
}
