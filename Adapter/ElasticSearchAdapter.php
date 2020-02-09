<?php
class ElasticSearchAdapter implements ISearchEngineAdapter
{
    private $elasticSearchClient;
    private $response = [];

    public function __construct(\Elasticsearch\Client $elasticSearchClient)
    {
        $this->elasticSearchClient = $elasticSearchClient;
    }

    public function search($query)
    {
        $this->response = $this->elasticSearchClient->search($query);
    }

    public function getSearchResponse()
    {
        $response = [
            'total' => $this->response['hits']['total']['value'],
            'message' => '<small>Yaklaşık <b>'.$this->response['hits']['total']['value'].'</b> sonuç bulundu</small>',
            'data' => [],
            'suggest' => []
        ];

        foreach ($this->response['hits']['hits'] as $key => $item) {
            $response['data'][$key] = $item['_source'];
            $response['data'][$key]['_score'] = $item['_score'];
            if (!empty($item['highlight'])) {
                $response['data'][$key]['highlight'] = $item['highlight'];
            }
        }
        if (!empty($this->response['suggest'])) {
            $response['suggest'] = $this->response['suggest'];
        }
        return $response;
    }
}