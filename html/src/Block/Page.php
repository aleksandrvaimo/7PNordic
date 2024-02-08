<?php
/**
 * Copyright © ...
 */

namespace Block;

use Api\PageInterface;

class Page implements PageInterface
{
    public function getTitle(): string
    {
        return self::PAGE_TITLE;
    }

    public function getCreateFormTitle(): string
    {
        return self::CREATE_FORM_TITLE;
    }

    public function getCollectionTitle(): string
    {
        return self::COLLECTION_TITLE;
    }

    public function getEmptyCollectionTitle(): string
    {
        return self::EMPTY_COLLECTION_TITLE;
    }

    public function getSearchFormTitle(): string
    {
        return self::SEARCH_FORM_TITLE;
    }

    public function getUrl(): string
    {
        return './action.php';
    }

    /**
     * Generate url for sort links
     *
     * @param string|null $sort
     *
     * @return string
     */
    public function getSortUrl(?string $sort = null): string
    {
        $search = $_GET['q'] ?? null;
        $queryStrings = '';

        if ($search) {
            $queryStrings = '?q=' . $search;
        }

        $queryStrings .= empty($queryStrings) ? '?' : '&';
        $queryStrings .= 'sort=' . $sort;
        $url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . '://' . $_SERVER['HTTP_HOST'] . $queryStrings;

        return htmlspecialchars($url, ENT_QUOTES, 'UTF-8' );
    }
}
