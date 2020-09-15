<?php
namespace core;

class BaseProvider
{
    private static $_db;

    public function __construct()
    {
        self::$_db = new Database();
    }

    public static function getDb()
    {
        return self::$_db;
    }

}