<?php

namespace App\Repositories;

use App\Models\Page;
use App\Support\Repositories\RepositoryInterface;

class PageRepository extends BaseRepository implements RepositoryInterface
{
    public function model() : string
    {
        return Page::class;
    }

    /**
     * @param string $pageName
     * @param string $title
     * @param string $content
     * @return Page|null
     * @throws \App\Exceptions\RepositoryException
     */
    public function createBulky(
        string $pageName,
        string $title,
        string $content
    ) : ?Page {
        return $this->create([
            'page_name' => $pageName,
            'title' => $title,
            'content' => $content
        ]);
    }

    /**
     * @param Page $page
     * @param string $pageName
     * @param string $title
     * @param string $content
     * @return Page|null
     * @throws \App\Exceptions\RepositoryException
     */
    public function updateBulky(
        Page $page,
        string $pageName,
        string $title,
        string $content
    ) : ?Page {
        $data = [
            'page_name' => $pageName,
            'title' => $title,
            'content' => $content
        ];

        return $this->update($data, $page->id);
    }
}
