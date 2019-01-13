<?php

namespace App\Http\Requests\Dashboard\Pages;

/**
 * Class StoreRequest
 * @package App\Http\Requests\Dashboard\Pages
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
