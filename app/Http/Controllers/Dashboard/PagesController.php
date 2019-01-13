<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\Pages\UpdateRequest;
use App\Repositories\Permission\PageRepository;

class PagesController extends BaseController
{
    /**
     * @param PageRepository $pageRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\RepositoryException
     */
    public function index(PageRepository $pageRepository)
    {
        $users = $pageRepository->getForUser($this->getUser());

        return view('dashboard.pages.index', [
            'items' => $users
        ]);
    }

    /**
     * @param int $id
     * @param PageRepository $pageRepository
     * @return PagesController|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \App\Exceptions\RepositoryException
     */
    public function edit(int $id, PageRepository $pageRepository)
    {
        $page = $pageRepository->findForUser($id, $this->getUser());

        if ($page === null) {
            return $this->error('Не удалось найти страницу.');
        }

        return view('dashboard.pages.edit', [
            'item'    => $page,
        ]);
    }

    /**
     * @param int $id
     * @param UpdateRequest $updateRequest
     * @param PageRepository $pageRepository
     * @return PagesController|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\RepositoryException
     */
    public function update(
        int $id, UpdateRequest $updateRequest, PageRepository $pageRepository
    ) {
        $page = $pageRepository->findForUser($id, $this->getUser());

        if ($page === null) {
            return $this->error('Не удалось найти страницу.');
        }

        $page = $pageRepository->updateBulky(
            $page,
            $updateRequest->input('page_name'),
            $updateRequest->input('title'),
            $updateRequest->input('content')
        );

        if ($page === null) {
            return $this->error('Не удалось обновить страницу.');
        }

        return $this->success('Страница была успешно обновлена.');
    }
}
