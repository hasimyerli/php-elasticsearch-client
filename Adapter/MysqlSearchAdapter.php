<?php

namespace Adapter;

use library\MysqlSearch;

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
        $total = $this->response['total'];

        $response = [
            'message' => '<small>Yaklaşık <b>'.$total.'</b> sonuç bulundu</small>',
            'data' => []
        ];

        foreach ($this->response['data'] as $key => $item) {
            $response[$key] = $item;
        }

        return $response;
    }
}