<?php
class ElasticSearchBuilder extends \Elasticsearch\ClientBuilder
{
    public static function connect()
    {
        return ElasticSearchBuilder::create()->build();
    }
}