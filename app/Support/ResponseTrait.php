<?php

namespace App\Support;

use App\Support\Api\ApiResponseTrait;
use Request;
use URL;

trait ResponseTrait
{
    use ApiResponseTrait;

    /**
     * @param string $message
     * @param string|null $route
     * @param array $params
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function success(string $message = '', string $route = null, array $params = [])
    {
        return $this->successfulResponse($message, $route, $params);
    }

    /**
     * @param string $message
     * @param string|null $route
     * @param array $params
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function warning(string $message = '', string $route = null, array $params = [])
    {
        return $this->successfulResponse($message, $route, $params, 'warning');
    }

    /**
     * @param string $message
     * @param string|null $route
     * @param array $params
     * @param string $dataKey
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    private function successfulResponse(
        string $message = '',
        string $route = null,
        array $params = [],
        string $dataKey = 'success'
    ) {
        if (Request::ajax() || Request::wantsJson()) {
            return $this->respondWithSuccess($params, $message);
        } else {
            $redirect = redirect()->to($route === null ? URL::previous() : $route);
            if ($message) {
                $redirect = $redirect->with($dataKey, $message);
            }
            foreach ($params as $key => $value) {
                $redirect = $redirect->with($key, $value);
            }
            return $redirect;
        }
    }

    /**
     * @param array|string $messages
     * @param string|null $route
     * @param array $params
     * @param array|null $exceptInput
     * @param int $statusCode
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function error(
        $messages = [],
        string $route = null,
        array $params = [],
        array $exceptInput = null,
        int $statusCode = 400
    ) {
        $messages = (array) $messages;
        if ($exceptInput === null) {
            $exceptInput = ['password', 'password_confirmation'];
        }
        if (Request::ajax() || Request::wantsJson()) {
            return $this->respondRawError(array_first($messages), $statusCode);
        } else {
            $redirect = redirect()->to($route === null ? URL::previous() : $route)
                ->withErrors($messages)
                ->withInput(Request::except($exceptInput));
            foreach ($params as $key => $value) {
                $redirect = $redirect->with($key, $value);
            }
            return $redirect;
        }
    }
}
