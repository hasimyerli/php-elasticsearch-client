<?php

namespace Builder;

use Elasticsearch\ClientBuilder;

class ElasticSearchBuilder extends ClientBuilder
{
    public static function connect()
    {
        return ElasticSearchBuilder::create()->build();
    }
}