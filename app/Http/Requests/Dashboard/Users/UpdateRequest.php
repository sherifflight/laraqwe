<?php

namespace App\Http\Requests\Dashboard\Users;

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
