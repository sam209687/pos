<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\SanitizesInput;

abstract class BaseFormRequest extends FormRequest
{
    use SanitizesInput;

    protected function prepareForValidation()
    {
        $this->merge($this->sanitizeInput($this->all()));
    }
}
