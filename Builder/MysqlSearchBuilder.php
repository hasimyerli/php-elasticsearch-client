<?php

namespace Builder;

use library\MysqlSearch;

class MysqlSearchBuilder
{
    public static function connect()
    {
        return new MysqlSearch();
    }
}