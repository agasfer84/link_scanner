<?php
namespace models;

use core\BaseProvider;


class Projects extends BaseProvider
{
    const NONCHECKED_STATUS = 0;
    const CHECKED_STATUS = 1;

    public static function getTable()
    {
        return 'link_files';
    }

    public static function getOne()
    {
        $table = self::getTable();
        $query = "SELECT * FROM $table WHERE status = :status";
        $result = self::getDb()->prepare($query);
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $result->execute(["status" => self::NONCHECKED_STATUS]);

        return $result->fetchAll(\PDO::FETCH_ASSOC)[0];
    }

}