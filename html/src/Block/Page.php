<?php
/**
 * Copyright © ...
 */

namespace Block;

use Api\PageInterface;
use function htmlspecialchars;

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
        $queryStrings = $this->getQueryStrings();
        $queryStrings .= self::PARAM_SORT . '=' . $sort;

        return htmlspecialchars($this->getBaseUrl() . $queryStrings, ENT_QUOTES, 'UTF-8' );
    }

    public function isSearchUsed(): bool
    {
        return isset($_GET[self::PARAM_SEARCH]);
    }

    /**
     * @return string
     */
    private function getQueryStrings(): string
    {
        return $this->isSearchUsed()
            ? '?' . self::PARAM_SEARCH . '=' . $_GET[self::PARAM_SEARCH] . '&'
            : '?';
    }

    /**
     * @return string
     */
    private function getBaseUrl(): string
    {
        return (empty($_SERVER['HTTPS']) ? 'http' : 'https') . '://' . $_SERVER['HTTP_HOST'];
    }
}
