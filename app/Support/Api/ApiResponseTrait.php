<?php

namespace App\Support\Api;

use Illuminate\Http\JsonResponse;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait
{
    /** @var int */
    private $statusCode = 200;

    /**
     * @param int $statusCode
     * @return $this
     */
    protected function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return int
     */
    protected function getStatusCode() : int
    {
        return $this->statusCode;
    }

    /**
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    private function respond(array $data = [], array $headers = []) : JsonResponse
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @SWG\Definition(
     *   definition="ResponseWithSuccess",
     *   @SWG\Response(
     *     response=200,
     *     description="OK"
     *   ),
     *     @SWG\Property(
     *       property="data",
     *       type="object"
     *     ),
     *     @SWG\Property(
     *       property="message",
     *       type="string"
     *     ),
     *     @SWG\Property(
     *       property="pagination",
     *       type="object"
     *     )
     * )
     *
     * @param array|null $data
     * @param string|null $message
     * @param array|null $paginationData
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithSuccess(
        array $data = null,
        string $message = null,
        array $paginationData = null
    ) : JsonResponse {
        $responseBody = [
            'data' => ($data !== null ? $data : [])
        ];
        if ($message !== null) {
            $responseBody['data']['message'] = $message;
        }
        if ($paginationData !== null) {
            $responseBody['data']['pagination'] = $paginationData;
        }
        if (empty($responseBody['data'])) {
            $responseBody['data'] = new stdClass;
        }
        return $this->respond($responseBody);
    }

    /**
     * @SWG\Definition(
     *   definition="ResponseWithError",
     *   required={"error"},
     *   @SWG\Response(
     *     response=400,
     *     description="Error"
     *   ),
     *   @SWG\Property(
     *     property="error",
     *     type="object",
     *     @SWG\Property(
     *       property="message",
     *       type="string"
     *     )
     *   )
     * )
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithError(string $message = null) : JsonResponse
    {
        return $this->respondRawError($message);
    }


    /**
     * @SWG\Definition(
     *   definition="ResponseNotFound",
     *   required={"error"},
     *   @SWG\Response(
     *     response=404,
     *     description="Error"
     *   ),
     *   @SWG\Property(
     *     property="error",
     *     type="object",
     *     @SWG\Property(
     *       property="message",
     *       type="string"
     *     )
     *   )
     * )
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondNotFound(string $message = null) : JsonResponse
    {
        return $this->respondRawError($message, Response::HTTP_NOT_FOUND);
    }

    /**
     * @param $data
     * @param int $statusCode
     * @return JsonResponse
     */
    private function respondRawError($data, int $statusCode = 400) : JsonResponse
    {
        if (is_string($data)) {
            $responseBody = [
                'error' => []
            ];
            if ($data !== null) {
                $responseBody['error']['message'] = $data;
            }
            if (empty($responseBody['error'])) {
                $responseBody['error'] = new stdClass;
            }
        } elseif (is_array($data)) {
            $responseBody = [
                'error' => [
                    'messages' => $data
                ]
            ];
        } else {
            $responseBody = [
                'error' => [
                    'message' => 'Unknown error.'
                ]
            ];
        }

        return $this->setStatusCode($statusCode)
            ->respond($responseBody);
    }

    /**
     * @SWG\Definition(
     *   definition="ResponseWithValidationError",
     *   required={"error"},
     *   @SWG\Response(
     *     response=422,
     *     description="Validation Error"
     *   ),
     *   @SWG\Property(
     *     property="error",
     *     type="object",
     *     @SWG\Property(
     *       property="messages",
     *       type="array",
     *       @SWG\Items(type="string")
     *     )
     *   )
     * )
     *
     * @param array $messages
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithValidationError(array $messages) : JsonResponse
    {
        return $this->respondRawError($messages, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @SWG\Definition(
     *   definition="ResponseWithAuthorizationError",
     *   required={"error"},
     *   @SWG\Response(
     *     response=401,
     *     description="Authorization Error"
     *   ),
     *   @SWG\Property(
     *     property="error",
     *     type="object",
     *     @SWG\Property(
     *       property="message",
     *       type="array",
     *       @SWG\Items(type="string")
     *     )
     *   )
     * )
     *
     * @param string|null $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithAuthorizationError(string $message = null) : JsonResponse
    {
        $message = ($message === null ? 'Ошибка авторизации.' : $message);

        return $this->respondRawError($message, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @SWG\Definition(
     *   definition="ResponseWithUpgradeRequired",
     *   required={"error"},
     *   @SWG\Response(
     *     response=426,
     *     description="Upgrade Required"
     *   ),
     *   @SWG\Property(
     *     property="error",
     *     type="object",
     *     @SWG\Property(
     *       property="message",
     *       type="array",
     *       @SWG\Items(type="string")
     *     )
     *   )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithUpgradeRequired() : JsonResponse
    {
        return $this->respondRawError('Необходимо обновление приложения.', Response::HTTP_UPGRADE_REQUIRED);
    }
}
