<?php
/**
 * Symfony "dd" can be like method.
 *
 * @param $param
 */
function dd($param)
{
    echo "<pre>";
    print_r($param);
    echo "</pre>";
    exit;
}