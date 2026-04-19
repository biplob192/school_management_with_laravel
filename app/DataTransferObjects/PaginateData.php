<?php

namespace App\DataTransferObjects;

class PaginateData
{
    public int $page;
    public int $perPage;
    public ?string $search;
    public string $sortKey;
    public string $sortOrder;
    public array $selectFields;
    public array $withRelations;
    public array $relationModelSearch;
    public array $conditions;
    public array $filterWithDates;
    public array $customConditions;
    public array $searchableColumns;
    public array $specialSearch;

    public function __construct(
        int $page,
        int $perPage,
        ?string $search,
        string $sortKey,
        string $sortOrder,
        array $selectFields,
        array $withRelations,
        array $relationModelSearch,
        array $conditions,
        array $filterWithDates,
        array $customConditions,
        array $searchableColumns,
        array $specialSearch
    ) {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->search = $search;
        $this->sortKey = $sortKey;
        $this->sortOrder = $sortOrder;
        $this->selectFields = $selectFields;
        $this->withRelations = $withRelations;
        $this->relationModelSearch = $relationModelSearch;
        $this->conditions = $conditions;
        $this->filterWithDates = $filterWithDates;
        $this->customConditions = $customConditions;
        $this->searchableColumns = $searchableColumns;
        $this->specialSearch = $specialSearch;
    }
}
