<?php
/**
 * Copyright © ...
 */

namespace Api;

interface PageInterface
{
    public const PAGE_TITLE = 'Page Title';
    public const CREATE_FORM_TITLE = 'Create New Customer';
    public const COLLECTION_TITLE = 'Customer Collection';
    public const EMPTY_COLLECTION_TITLE = 'Collection is empty';
    public const SEARCH_FORM_TITLE = 'Search by Username';
    public const PARAM_SORT = 'sort';
    public const PARAM_SEARCH = 'q';

    public function getTitle(): string;
    public function getCreateFormTitle(): string;
    public function getCollectionTitle(): string;
    public function getEmptyCollectionTitle(): string;
    public function getSearchFormTitle(): string;
    public function getUrl(): string;
    public function getSortUrl(?string $sort = null): string;
    public function isSearchUsed(): bool;
}
