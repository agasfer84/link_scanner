<?php
declare(strict_types = 1);
namespace core;

class BaseProvider
{
    private static $_db;

    public function __construct()
    {
        self::$_db = new Database();
    }

    public static function getDb(): Database
    {
        return self::$_db;
    }

}