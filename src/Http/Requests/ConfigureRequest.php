<?php

declare(strict_types=1);

namespace MyParcelCom\Integration\Configuration\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigureRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'data.properties'         => 'array',
            'data.properties.*.name'  => 'required|string',
            'data.properties.*.value' => 'required',
        ];
    }
}
