<?php
class MysqlSearchAdapter implements ISearchEngineAdapter
{
    private $mysqlSearchClient;
    private $response;

    public function __construct(MysqlSearch $mysqlSearchClient)
    {
        $this->mysqlSearchClient = $mysqlSearchClient;
    }

    public function createIndex($query)
    {
        // TODO: Implement createIndex() method.
    }

    public function search($query)
    {
        $this->response = $this->mysqlSearchClient->searchData($query);
    }

    public function getSearchResponse()
    {
        $response = [];
        foreach ($this->response['result'] as $key => $item) {
            $response[$key] = $item['data'];
        }
        return $response;
    }
}