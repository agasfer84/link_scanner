<?php
declare(strict_types = 1);
namespace models;

use core\BaseProvider;

class Directories extends BaseProvider
{
    public static $_rows_get_limit = 50;

    const NONCHECKED_STATUS = 0;
    const CHECKED_STATUS = 1;

    public static function getTable(): string
    {
        return 'link_directories';
    }

    public static function getByStatus(int $status): array
    {
        $table = self::getTable();
        $query = "SELECT * FROM $table WHERE status = :status LIMIT " . self::$_rows_get_limit;
        $result = self::getDb()->prepare($query);
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        $result->execute(["status" => $status]);

        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create(string $path, int $status, int $project_id)
    {
        $table = self::getTable();
        $query = "INSERT INTO $table (path, status, project_id) VALUES (:path, :status, :project_id)";
        $result = self::getDb()->prepare($query);
        $result->execute(["path" => $path, "status" => $status, "project_id" => $project_id]);
    }

    public function setStatus(int $id, int $status)
    {
        $table = self::getTable();
        $nonchecked = self::NONCHECKED_STATUS;
        $query = "UPDATE $table SET status = :status WHERE id = :id AND status = $nonchecked LIMIT 1";
        $result = self::getDb()->prepare($query);
        $result->execute(["id" => $id, "status" => $status]);
    }

    public static function findByPath(string $path, int $project_id): ?array
    {
        $table = self::getTable();
        $query = "SELECT * FROM $table WHERE path = :path AND project_id = :project_id";
        $array = self::getDb()->prepare($query);
        $array->setFetchMode(\PDO::FETCH_ASSOC);
        $array->execute(["path" => $path, "project_id" => $project_id]);
        $result = $array->fetchAll(\PDO::FETCH_ASSOC);
        $result = (!empty($result)) ? $result : null;

        return $result;
    }
}