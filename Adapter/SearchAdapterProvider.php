<?php

namespace Adapter;

class SearchAdapterProvider
{
    private $searchEngineClient;

    public function __construct(ISearchEngineAdapter $searchEngineAdapter)
    {
        $this->searchEngineClient = $searchEngineAdapter;
    }

    public function search($query)
    {
        return $this->searchEngineClient->search($query);
    }

    public function getSearchResponse()
    {
        return $this->searchEngineClient->getSearchResponse();
    }
}