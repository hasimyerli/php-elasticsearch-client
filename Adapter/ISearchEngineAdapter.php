<?php

namespace Adapter;

interface ISearchEngineAdapter
{
    public function search($query);

    public function getSearchResponse();
}