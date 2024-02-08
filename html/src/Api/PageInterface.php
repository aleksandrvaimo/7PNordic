<?php
/**
 * Copyright © ...
 */

namespace Api;

interface PageInterface
{
    const PAGE_TITLE = 'Page Title';
    const CREATE_FORM_TITLE = 'Create New Customer';
    const COLLECTION_TITLE = 'Customer Collection';
    const EMPTY_COLLECTION_TITLE = 'Collection is empty';
    const SEARCH_FORM_TITLE = 'Search by Username';

    public function getTitle(): string;
    public function getCreateFormTitle(): string;
    public function getCollectionTitle(): string;
    public function getEmptyCollectionTitle(): string;
    public function getSearchFormTitle(): string;
    public function getUrl(): string;
    public function getSortUrl(?string $sort = null): string;
}
