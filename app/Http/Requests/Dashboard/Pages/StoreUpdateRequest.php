<?php

namespace App\Http\Requests\Dashboard\Pages;

use App\Http\Requests\Dashboard\BaseRequest;

/**
 * Class StoreUpdateRequest
 * @package App\Http\Requests\Dashboard\Pages
 */
abstract class StoreUpdateRequest extends BaseRequest
{
    /**
     * @return array
     * @throws \App\Exceptions\RepositoryException
     */
    public function rules()
    {
        return [
            'page_name' => 'required',
            'title' => 'required',
            'content' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'page_name.required' => 'Необходимо указать название страницы.',
            'title.required' => 'Необходимо указать заголовок.',
            'content.required' => 'Необходимо указать контент.',
        ];
    }
}
