<?php
declare(strict_types = 1);
namespace models;

use core\BaseProvider;


class Projects extends BaseProvider
{
    const NONCHECKED_STATUS = 0;
    const CHECKED_STATUS = 1;

    public static function getTable(): string
    {
        return 'link_files';
    }

    public static function getOne(): ?array
    {
        $table = self::getTable();
        $query = "SELECT * FROM $table WHERE status = :status";
        $result = self::getDb()->prepare($query);
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $result->execute(["status" => self::NONCHECKED_STATUS]);

        return $result->fetchAll(\PDO::FETCH_ASSOC)[0];
    }

}