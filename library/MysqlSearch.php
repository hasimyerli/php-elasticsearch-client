<?php
class MysqlSearch
{
    public function __construct()
    {
        //TODO::connect db
    }

    public function searchData($query)
    {
        return [
            'result' => [
                [
                    'table' => "table-2",
                    'data' => [
                        'name' => 'Php Günlüğü',
                        'author' => 'Kamil Örs'
                    ]
                ],
                [
                    'table' => "table-1",
                    'data' => [
                        'name' => 'A-z php',
                        'author' => 'Rıza Çelik'
                    ]
                ]
            ],
        ];
    }
}