<?php

namespace Adapter;

use Elasticsearch\Client;

class ElasticSearchAdapter implements ISearchEngineAdapter
{
    private $elasticSearchClient;
    private $response = [];

    public function __construct(Client $elasticSearchClient)
    {
        $this->elasticSearchClient = $elasticSearchClient;
    }

    public function search($query)
    {
        $this->response = $this->elasticSearchClient->search($query);
    }

    public function getSearchResponse()
    {
        $total = $this->response['hits']['total']['value'];

        $response = [
            'message' => '<small>Yaklaşık <b>'.$total.'</b> sonuç bulundu</small>',
            'data' => []
        ];

        foreach ($this->response['hits']['hits'] as $key => $item) {
            $response['data'][$key] = $item['_source'];
        }

        return $response;
    }
}