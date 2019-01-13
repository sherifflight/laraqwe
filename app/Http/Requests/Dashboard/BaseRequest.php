<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\Request;
use App\Models\User;
use App\Support\ResponseTrait;

abstract class BaseRequest extends Request
{
    use ResponseTrait;

    /** @var array|null */
    protected $only = null;

    /**
     * @param null $keys
     * @return array
     */
    public function all($keys = NULL)
    {
        $inputArray = parent::all($keys);
        if (is_array($this->only)) {
            $inputArray = array_intersect_key($inputArray, array_flip($this->only));
        }
        $this->modifyInput($inputArray);
        $this->replace($inputArray);
        return $inputArray;
    }

    /**
     * @param array $inputArray
     */
    protected function modifyInput(array &$inputArray)
    {
        //
    }

    /**
     * @param array $errors
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function response(array $errors)
    {
        $plainErrorsArray = [];
        foreach ($errors as $errorGroup) {
            if (is_array($errorGroup)) {
                $plainErrorsArray = array_merge($plainErrorsArray, $errorGroup);
            }
        }
        return $this->error($plainErrorsArray, null, [], null, 422);
    }

    /**
     * @return User
     */
    public function getUser() : User
    {
        return $this->user('dashboard');
    }
}
