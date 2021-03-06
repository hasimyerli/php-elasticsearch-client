<?php
require 'vendor/autoload.php';

$searchAdapterProvider = new \Adapter\SearchAdapterProvider(
    new \Adapter\ElasticSearchAdapter(\Builder\ElasticSearchBuilder::connect())
);

$productService = new \Service\ProductService($searchAdapterProvider);

$search = (isset($_POST['search'])) ? $_POST['search'] : "";
$field = (isset($_POST['field'])) ? $_POST['field'] : "";

$fields = [ "isbn^1", "categories^3", "authors^5", "title^7" ];

if (!empty($field)) {
    $fields = [$field];
}

$query = [
    'index' => 'book_index',
    'body'  => [
        'from' => 0,
        'size' => 10,
        'query' => [
            'multi_match' => [
                'query' => $search,
                "minimum_should_match" => '50%', #ref: 50% https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-minimum-should-match.html
                "fields" => $fields
            ],
        ]
    ]
];

$search = $productService->searchProduct($query);
echo json_encode($search);
