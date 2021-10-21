<?php

namespace App\Config;

class MysqlConnection
{
    public static function config(): array
    {
        return json_decode(file_get_contents('App/Config/config.json',), true);
    }
}
