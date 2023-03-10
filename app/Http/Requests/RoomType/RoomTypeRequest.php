<?php

namespace App\Http\Requests\RoomType;

use Illuminate\Foundation\Http\FormRequest;

class RoomTypeRequest extends FormRequest
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
    protected $redirect = '/RoomType/RoomType_create';
    public function rules()
    {
        return [
            'RoomTypeCode' => 'required | max:4 ',
            'RoomTypeName' => 'required | max:15 ',
            'RoomTypeAbName' => 'required | max:5',
            'RoomTypeDiv' => 'required | max:10',
            'OperationDiv' => 'required | max:5',
            'RemainingRoomDiv' => 'required | max:5 | numeric ',
            'RealTypeCode' => 'max:4',
            'Hidden' => 'max:1 | numeric',
            'DisplayOrder' => 'required | numeric | max:10000000000',
        ];
    }
}
