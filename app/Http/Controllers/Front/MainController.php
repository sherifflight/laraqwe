<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Repositories\PageRepository;

class MainController extends Controller
{
    /**
     * @param PageRepository $pageRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\RepositoryException
     */
    public function index(PageRepository $pageRepository)
    {
        /** @var Page $mainPage */
        $mainPage = $pageRepository->first();

        return view('front.welcome', [
            'mainPage' => $mainPage
        ]);
    }
}
