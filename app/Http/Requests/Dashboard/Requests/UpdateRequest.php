<?php

namespace App\Http\Requests\Dashboard\Requests;

/**
 * Class UpdateRequest
 * @package App\Http\Requests\Dashboard\Requests
 */
class UpdateRequest extends StoreUpdateRequest
{
    public function rules()
    {
        return parent::rules();
    }

    public function messages()
    {
        return parent::messages();
    }
}
