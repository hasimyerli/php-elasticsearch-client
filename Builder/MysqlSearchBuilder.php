<?php
class MysqlSearchBuilder
{
    public static function connect()
    {
        return new MysqlSearch();
    }
}