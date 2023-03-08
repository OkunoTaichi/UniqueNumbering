<?php

namespace App\Http\Requests\RoomType;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
    protected $redirect = '/Room/Room_create';
    public function rules()
    {
        return [
            'RoomNo' => 'required | max:10 | numeric ',
            'BuildingCode' => 'required | max:3 ',
            'RoomTypeCode' => 'required | max:4',
            'RoomName' => 'required | max:10',
            'RoomAbName' => 'required | max:5',
            'CapacityMax' => 'required | max:5 | numeric ',
            'CapacityMin' => 'required | max:5 | numeric ',
            'Floor' => 'required | max:5 | numeric ',

            'Hidden' => 'max:1 | numeric',
            'DisplayOrder' => 'required | numeric | max:10000000000',
        ];
    }
}
