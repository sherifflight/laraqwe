<?php

namespace App\Http\Requests\Dashboard\Requests;

use App\Http\Requests\Dashboard\BaseRequest;

/**
 * Class StoreUpdateRequest
 * @package App\Http\Requests\Dashboard\Requests
 */
abstract class StoreUpdateRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'event_name' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'education_level' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'event_name.required' => 'Необходимо указать название мероприятия.',
            'name.required' => 'Необходимо указать Имя.',
            'surname.required' => 'Необходимо указать Фамилию.',
            'email.required' => 'Необходимо указать email.',
            'phone.required' => 'Необходимо указать телефон.',
            'education_level.required' => 'Необходимо указать уровень образлвания.',
        ];
    }
}
