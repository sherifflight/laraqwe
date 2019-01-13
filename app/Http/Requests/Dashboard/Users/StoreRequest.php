<?php

namespace App\Http\Requests\Dashboard\Users;

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
