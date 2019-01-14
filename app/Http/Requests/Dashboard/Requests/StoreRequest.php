<?php

namespace App\Http\Requests\Dashboard\Requests;

/**
 * Class StoreRequest
 * @package App\Http\Requests\Dashboard\Requests
 */
class StoreRequest extends StoreUpdateRequest
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
