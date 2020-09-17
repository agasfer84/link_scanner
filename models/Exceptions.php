<?php
declare(strict_types = 1);
namespace models;

use core\BaseProvider;

class Exceptions extends BaseProvider
{

    public static function getTable(): string
    {
        return 'link_excetions';
    }

    public static function getByProjectId(int $project_id): array
    {
        $table = self::getTable();
        $query = "SELECT * FROM $table WHERE project_id = :project_id";
        $result = self::getDb()->prepare($query);
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $result->execute(["project_id" => $project_id]);

        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }


}