<?php

namespace App\Http\Requests;

use Pearl\RequestValidate\RequestAbstract;

class CompaniesList extends RequestAbstract
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'page'            => 'integer',
            'limit'           => 'integer',
            'orderBy'         => 'string',
            'scoreTotal'      => 'integer',
            'sortBy'          => 'in:asc,desc',
            'exchangeSymbols' => 'string'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            //
        ];
    }
}
