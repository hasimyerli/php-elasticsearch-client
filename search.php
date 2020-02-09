<?php
require 'vendor/autoload.php';
include "helper/helper.php";
include "Adapter/ISearchEngineAdapter.php";
include "Builder/ElasticSearchBuilder.php";
include "Builder/MysqlSearchBuilder.php";
include "library/MysqlSearch.php";
include "Service/ProductService.php";
include "Adapter/ElasticSearchAdapter.php";
include "Adapter/MysqlSearchAdapter.php";
include "Adapter/SearchAdapterProvider.php";

$searchAdapterProvider = new SearchAdapterProvider(
    new ElasticSearchAdapter(ElasticSearchBuilder::connect())
);

$productService = new ProductService($searchAdapterProvider);
$search = (isset($_POST['search'])) ? $_POST['search'] : "";
$start = (isset($_POST['start'])) ? $_POST['start'] : 0;
$field = (isset($_POST['field'])) ? $_POST['field'] : "";

$fields = [ "isbn^1", "categories^3", "authors^5", "title^7" ];

$highlight_field = [
    'isbn' => new \stdClass(),
    'title' => new \stdClass(),
    'categories' => new \stdClass(),
    'authors' => new \stdClass()
];

if (!empty($field)) {
    $fields = [$field];
    $highlight_field = [
        $field => new \stdClass()
    ];
}

$query = [
    'index' => 'book_index',
    'body'  => [
        'from' => $start,
        'size' => 10,
        'query' => [
            'multi_match' => [
                'query' => $search,
                "minimum_should_match" => '50%', #red: 50% https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-minimum-should-match.html
                #"fuzziness" => 1,
                "fields" => $fields
            ],
        ],
        'highlight' => [
            'pre_tags' =>  ["<span style='color:red;'>"],
            "post_tags" => ["</span>"],
            'fields' => $highlight_field,
            'require_field_match' => false
        ]
    ]
];

$search = $productService->searchProduct($query);
echo json_encode($search);
