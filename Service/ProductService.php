<?php

namespace Service;

use Adapter\SearchAdapterProvider;

class ProductService
{
    private $searchAdapter;

    public function __construct(SearchAdapterProvider $searchAdapter)
    {
        $this->searchAdapter = $searchAdapter;
    }

    public function searchProduct($query)
    {
        $this->searchAdapter->search($query);
        return $this->searchAdapter->getSearchResponse();
    }

}