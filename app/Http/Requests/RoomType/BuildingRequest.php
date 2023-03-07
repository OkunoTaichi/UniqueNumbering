<?php

namespace App\Http\Requests\RoomType;

use Illuminate\Foundation\Http\FormRequest;

class BuildingRequest extends FormRequest
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
    protected $redirect = '/Building/Building_create';
    public function rules()
    {
        return [
            'BuildingCode' => 'required | max:3 | regex:/^[a-zA-Z0-9 -@\[-~]+$/ ',
            'BuildingName' => 'required | max:10',
            'BuildingAbName' => 'required | max:5',

            'Hidden' => 'max:1 | numeric',
            'DisplayOrder' => 'required | numeric | max:10000000000',
        ];
    }
}
