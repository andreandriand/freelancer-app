<?php

namespace App\Http\Requests\Dashboard\Service;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UpdateServiceRequest extends FormRequest
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
            "title" => [
                'required',
                'string',
                'max:255',
            ],
            "description" => [
                'required',
                'string',
                'max:5000',
            ],
            "price" => [
                'required',
                'string',
            ],
            "delivery_time" => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],
            "revision_limit" => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
            "note" => [
                'nullable',
                'string',
                'max:5000',
            ],
        ];
    }
}
