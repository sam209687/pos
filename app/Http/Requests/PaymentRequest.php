<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'amount_paid' => ['required', 'numeric', 'min:0'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'reference_number' => ['nullable', 'string', 'max:255'],
        ];
    }
}
