<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Requests\StoreRequest;
use App\Repositories\RequestRepository;

/**
 * Class RequestsController
 * @package App\Http\Controllers\Front
 */
class RequestsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('front.request');
    }

    /**
     * @param StoreRequest $storeRequest
     * @param RequestRepository $requestRepository
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\RepositoryException
     */
    public function store(StoreRequest $storeRequest, RequestRepository $requestRepository)
    {
        $request = $requestRepository->createBulky(
            $storeRequest->input('event_name'),
            $storeRequest->input('name'),
            $storeRequest->input('surname'),
            $storeRequest->input('email'),
            $storeRequest->input('phone'),
            $storeRequest->input('education_level')
        );

        $messageKey = 'success';
        $messageValue = 'Request successfully sended.';
        if ($request === null) {
            $messageKey = 'error';
            $messageValue = 'Request failed.';
        }

        return redirect()->route('front.request.create')->with($messageKey, $messageValue);
    }
}
