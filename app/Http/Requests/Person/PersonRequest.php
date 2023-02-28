<?php

namespace App\Http\Requests\Person;

use Illuminate\Foundation\Http\FormRequest;

class PersonRequest extends FormRequest
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
     * @return array
     */
    protected $redirect = '/Person/Person_create';
    public function rules()
    {
        return [
            'PersonCode' => 'required | max:10',
            'PersonName' => 'required | max:8',
            'AuthorityCode' => 'required | numeric | max:10000000000',
            'Password' => 'required | min:8| max:20',
            'Hidden' => 'max:1 | numeric',
            'DisplayOrder' => 'required | numeric | max:10000000000',
        ];
    }
}
