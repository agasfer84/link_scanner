<?php
declare(strict_types = 1);
namespace models;

use core\BaseProvider;

class Files extends BaseProvider
{
    public static $_rows_get_limit = 100;
    public $allowed_extensions = ['php', 'html'];

    const NONCHECKED_STATUS = 0;
    const CHECKED_STATUS = 1;

    public static function getTable(): string
    {
        return 'link_files';
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

    public function create(string $path, int $status, int $directory_id)
    {
        $table = self::getTable();
        $query = "INSERT INTO $table (path, status, directory_id) VALUES (:path, :status, :directory_id)";
        $result = self::getDb()->prepare($query);
        $result->execute(["path" => $path, "status" => $status, "directory_id" => $directory_id]);
    }

    public function setStatus(int $id, int $status)
    {
        $table = self::getTable();
        $nonchecked = self::NONCHECKED_STATUS;
        $query = "UPDATE $table SET status = :status WHERE id = :id AND status = $nonchecked LIMIT 1";
        $result = self::getDb()->prepare($query);
        $result->execute(["id" => $id, "status" => $status]);
    }

    public static function findByPath(string $path): ?array
    {
        $table = self::getTable();
        $query = "SELECT * FROM $table WHERE path = :path";
        $array = self::getDb()->prepare($query);
        $array->setFetchMode(\PDO::FETCH_ASSOC);
        $array->execute(["path" => $path]);
        $result = $array->fetchAll(\PDO::FETCH_ASSOC);
        $result = (!empty($result)) ? $result : null;

        return $result;
    }

}