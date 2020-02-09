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
$search = ($_POST['search']) ? $_POST['search'] : "";
$query = [
    'index' => 'book_index',
    'body'  => [
        'from' => 0,
        'size' => 5,
        'suggest' =>  [
            'text' => $search,
            'title' => [
                'term' =>
                    ['field' => 'title', 'size' => 3, 'max_edits' => 2, 'prefix_length' => 1, 'sort' => 'score'],
            ],
            'authors' => [
                'term' =>
                    ['field' => 'authors', 'size' => 3, 'max_edits' => 2, 'prefix_length' => 1, 'sort' => 'score']
            ],
            'categories' => [
                'term' =>
                    ['field' => 'categories', 'size' => 3, 'max_edits' => 2, 'prefix_length' => 1, 'sort' => 'score'],
            ]
        ]
    ]
];

$query_2 = [
    'index' => 'phrase_suggester_index',
    'body'  => [
        'suggest' =>  [
            'text' => $search,
            'title' => [
                "phrase" => [
                    "field" => "title.trigram",
                    "size" => 3,
                    "gram_size" => 3,
                    'max_errors' => 2,
                    "direct_generator" => [
                        [
                            "field" => "title.trigram",
                            "suggest_mode" => "always"
                        ]
                    ],
                    "highlight" => [
                        "pre_tag" => "<em style='color:gold;'>",
                        "post_tag" => "</em>"
                    ]
                ]
            ],
            'categories' => [
                "phrase" => [
                    "field" => "categories.trigram",
                    "size" => 3,
                    "gram_size" => 3,
                    'max_errors' => 2,
                    "direct_generator" => [
                        [
                            "field" => "categories.trigram",
                            "suggest_mode" => "always"
                        ]
                    ],
                    "highlight" => [
                        "pre_tag" => "<em style='color:gold;'>",
                        "post_tag" => "</em>"
                    ]
                ]
            ],
            'authors' => [
                "phrase" => [
                    "field" => "authors.trigram",
                    "size" => 3,
                    "gram_size" => 3,
                    'max_errors' => 2,
                    "direct_generator" => [
                        [
                            "field" => "authors.trigram",
                            "suggest_mode" => "always"
                        ]
                    ],
                    "collate" => [
                        "query" => [
                            "source" => [
                                "match" => [
                                    "authors" => $search
                                ]
                            ]
                        ],
                        "params" =>  [
                            "field_name" => "authors"
                        ],
                        "prune" =>  true
                    ],
                    "highlight" => [
                        "pre_tag" => "<em style='color:gold;'>",
                        "post_tag" => "</em>"
                    ]
                ]
            ]
        ]
    ]
];

$query_3 = [
    'index' => 'completion_suggester_index',
    'body'  => [
        'suggest' =>  [
            'text' => $search,
            'title' => [
                'completion' => [
                    'field' => 'title',
                    'size' => 3,
                    "skip_duplicates" => true
                ]
            ],
            'authors' => [
                'completion' => [
                    'field' => 'authors',
                    'size' => 3,
                    "skip_duplicates" => true
                ]
            ],
            'categories' => [
                'completion' => [
                    'field' => 'categories',
                    'size' => 3,
                    "skip_duplicates" => true
                ]
            ]
        ]
    ]
];

$search = $productService->searchProduct($query_3);
echo json_encode($search);
