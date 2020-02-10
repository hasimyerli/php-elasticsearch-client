<?php
require 'vendor/autoload.php';

echo "<h3>Elastic Manager Service</h3>";

$manager = new \Service\ElasticManager(\Builder\ElasticSearchBuilder::connect());

/*
$query = [
    'index' => 'phrase_suggester_index'
];
$create = $manager->createIndex($query);

$query = [
    'index' => 'similarity_vector_index'
];
$create = $manager->createIndex($query);

$query = [
    'index' => 'term_suggestion_index',
    'body' => [
        'properties' => [
            'title' => [
                'type' => 'text'
            ],
            'title_vector' => [
                'type' => 'dense_vector',
                "dims" =>  512
            ],
            'tags' => [
                'type' => 'keyword'
            ]
        ]
    ]
];
$updateMappings = $manager->updateMappings($query);

$query = [
    'index' => 'book_index'
];
$create = $manager->createIndex($query);

$query = [
    'index' => 'phrase_suggester_index',
    'body' => [
        'settings' => [
            'index' => [
                "number_of_replicas" => "1",
            ],
            'analysis' => [
                'analyzer' => [
                    'trigram' => [
                        'type' => 'custom',
                        'tokenizer' => 'standard',
                        'filter' => ['lowercase','shingle'],
                    ],
                    'reverse' => [
                        'type' => 'custom',
                        'tokenizer' => 'standard',
                        'filter' => ['lowercase','reverse']
                    ]
                ],
                'filter' => [
                    'shingle' => [
                        'type' => 'shingle',
                        'min_shingle_size' => 2,
                        'max_shingle_size' => 3,
                    ]
                ]
            ]
        ]
    ]
];
$updateSettings = $manager->updateIndexSettings($query);

$settings = $manager->getSettings();

$query = [
    'index' => 'phrase_suggester_index',
    'body' => [
        '_source' => [
            'enabled' => true
        ],
        'properties' => [
            'title' => [
                'type' => 'text',
                "fields"=> [
                    "trigram"=> [
                        "type"=> "text",
                        "analyzer"=> "trigram"
                    ],
                    "reverse"=> [
                        "type"=> "text",
                        "analyzer"=> "reverse"
                    ]
                ]
            ],
            'isbn' => [
                'type' => 'text'
            ],
            'pageCount' => [
                'type' => 'text'
            ],
            'publishedDate' => [
                'type' => 'text'
            ],
            'thumbnailUrl' => [
                'type' => 'text'
            ],
            'status' => [
                'type' => 'text'
            ],
            'authors' => [
                'type' => 'text',
                "fields"=> [
                    "trigram"=> [
                        "type"=> "text",
                        "analyzer"=> "trigram"
                    ],
                    "reverse"=> [
                        "type"=> "text",
                        "analyzer"=> "reverse"
                    ]
                ]
            ],
            'categories' => [
                'type' => 'text',
                "fields"=> [
                    "trigram"=> [
                        "type"=> "text",
                        "analyzer"=> "trigram"
                    ],
                    "reverse"=> [
                        "type"=> "text",
                        "analyzer"=> "reverse"
                    ]
                ]
            ]
        ]
    ]
];
$updateMappings = $manager->updateMappings($query);

$mappings = $manager->getMappings();

$books = json_decode(file_get_contents('books.json'));

foreach ($books as $key => $book) {
    $query['body'][] = [
        'index' => [
            '_index' => 'book_index',
            '_id' => uniqid()
        ]
    ];

    $query['body'][] = (array)$book;

    if ($key) {
        $bulk = $manager->bulk($query);
    }

}

$bulk = $manager->bulk($query);

$query = [
    'index' => 'book_index',
    'body'  => [
        #'size' => 2,
        'query' => [
            'match' => [
                'title' => [
                    'query' => 'Spring Batch in Action',
                    "fuzziness" => 1,
                ]
            ]
        ]
    ]
];
$search = $manager->search($query);


$params = [
    'index' => 'book_index',
    'id'    => '5d810f422617d',
    'body'  => [
        'doc' => [
            'title' => 'java Spring Batch in Action'
        ]
    ]
];

$response = $manager->update($params);

$query = [
    'index' => 'book_index',
    'from' => 0,
    'size' => 400,
];
$search = $manager->search($query);

$item = $manager->get([
    'index' => 'book_index',
    'id'    => '5d810f4226061'
]);

$item = $manager->delete([
    'index' => 'product_index',
    'id'    => '219073'
]);
*/