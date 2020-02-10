<?php

namespace Service;

use Elasticsearch\Client;

class ElasticManager
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get($query)
    {
        return $this->client->get($query);
    }

    public function delete($query)
    {
        return $this->client->delete($query);
    }

    public function update($query)
    {
        return $this->client->update($query);
    }

    public function search($query=[])
    {
        return $this->client->search($query);
    }

    public function createIndex($query)
    {
        return $this->client->indices()->create($query);
    }

    public function deleteIndex($query)
    {
        return $this->client->indices()->delete($query);
    }

    public function updateIndexSettings($query)
    {
        return $this->client->indices()->putSettings($query);
    }

    public function getSettings()
    {
        return $this->client->indices()->getSettings();
    }

    public function updateMappings($query)
    {
        return $this->client->indices()->putMapping($query);
    }

    public function getMappings()
    {
        return $this->client->indices()->getMapping();
    }

    public function bulk($query)
    {
        return $this->client->bulk($query);
    }
}