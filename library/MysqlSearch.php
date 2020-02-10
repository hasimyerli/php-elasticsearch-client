<?php

namespace library;

class MysqlSearch
{
    public function __construct()
    {
        //TODO::connect db
    }

    public function searchData($query)
    {
        return [
            "total" => 2,
            "data" => [
                'title' => 'Flex 3 in Action',
                "isbn" => "1933988746",
                'authors' => ["Tariq Ahmed with Jon Hirschi", "Faisal Abid"],
                'categories' => ["Internet"],
                "thumbnailUrl" => "https://s3.amazonaws.com/AKIAJC5RLADLUMVRPFDQ.book-thumb-images/ahmed.jpg"
            ],
            [
                'title' => 'Flex 4 in Action',
                "isbn" => "1935182420",
                'authors' => ["Tariq Ahmed", "Dan Orlando", "John C. Bland II", "Joel Hooks"],
                'categories' => ["Internet"],
                "thumbnailUrl" => "https://s3.amazonaws.com/AKIAJC5RLADLUMVRPFDQ.book-thumb-images/ahmed2.jpg"
            ]
        ];
    }
}