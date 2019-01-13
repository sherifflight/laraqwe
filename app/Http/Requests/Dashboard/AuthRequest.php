<?php

namespace App\Http\Requests\Dashboard;

class AuthRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'email'                => 'required',
            'password'             => 'required',
//            'g-recaptcha-response' => 'required|recaptcha'
        ];
    }

    public function messages() : array
    {
        return [
            'email.required'                 => 'Необходимо ввести email.',
            'password.required'              => 'Необходимо ввести пароль.',
//            'g-recaptcha-response.required'  => 'Докажите, что Вы не робот.',
//            'g-recaptcha-response.recaptcha' => 'Докажите, что Вы не робот.',
        ];
    }
}
