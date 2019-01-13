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
     * @param string $text
     * @return Page|null
     * @throws \App\Exceptions\RepositoryException
     */
    public function createBulky(
        string $pageName,
        string $title,
        string $text
    ) : ?Page {
        return $this->create([
            'page_name' => $pageName,
            'title' => $title,
            'text' => $text
        ]);
    }

    /**
     * @param Page $page
     * @param string $pageName
     * @param string $title
     * @param string $text
     * @return Page|null
     * @throws \App\Exceptions\RepositoryException
     */
    public function updateBulky(
        Page $page,
        string $pageName,
        string $title,
        string $text
    ) : ?Page {
        $data = [
            'page_name' => $pageName,
            'title' => $title,
            'text' => $text
        ];

        return $this->update($data, $page->id);
    }
}
