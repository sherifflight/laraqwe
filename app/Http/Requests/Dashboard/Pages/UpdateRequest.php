<?php

namespace App\Http\Requests\Dashboard\Pages;

/**
 * Class UpdateRequest
 * @package App\Http\Requests\Dashboard\Pages
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
