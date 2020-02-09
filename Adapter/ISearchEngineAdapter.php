<?php
interface ISearchEngineAdapter
{
    public function search($query);

    public function getSearchResponse();
}