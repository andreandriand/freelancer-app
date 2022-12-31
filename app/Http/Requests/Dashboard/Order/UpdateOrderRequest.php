<?php

namespace App\Http\Requests\Dashboard\Order;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UpdateOrderRequest extends FormRequest
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
            "buyer_id" => [
                'nullable',
                'integer',
            ],
            "freelancer_id" => [
                'nullable',
                'integer',
            ],
            "file" => [
                'required',
                'mimes:pdf,doc,docx,zip,rar',
            ],
            "note" => [
                'required',
                'string',
                'max:10000',
            ],
            "expired" => [
                'nullable',
                'date',
            ],
            "order_status_id" => [
                'nullable',
                'integer',
            ],
        ];
    }
}
