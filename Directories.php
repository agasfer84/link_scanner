<?php
require_once(__DIR__."/Database.php");

class Directories
{
    private $db;
    private $table = 'link_directories';
    public $rows_get_limit = 50;

    const NONCHECKED_STATUS = 0;
    const CHECKED_STATUS = 1;

    public function __construct()
    {
        $db = new Database();
        $this->db = $db;
    }

    public function getByStatus($status)
    {
        $connection = $this->db;

        $query = "SELECT * FROM $this->table WHERE status = :status LIMIT $this->rows_get_limit";
        $result = $connection->prepare($query);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute(["status" => $status]);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($path, $status, $project_id)
    {
        $connection = $this->db;

        $query = "INSERT INTO $this->table (path, status, project_id) VALUES (:path, :status, :project_id)";
        $result = $connection->prepare($query);
        $result->execute(["path" => $path, "status" => $status, "project_id" => $project_id]);
    }

    public function setStatus($path, $status)
    {
        $connection = $this->db;
        $nonchecked = self::NONCHECKED_STATUS;

        $query = "UPDATE $this->table SET status = :status WHERE path = :path AND status = $nonchecked LIMIT 1";
        $result = $connection->prepare($query);
        $result->execute(["path" => $path, "status" => $status]);
    }

    public function findByPath($path)
    {
        $connection = $this->db;

        $query = "SELECT * FROM $this->table WHERE path = :path";
        $array = $connection->prepare($query);
        $array->setFetchMode(PDO::FETCH_ASSOC);
        $array->execute(["path" => $path]);
        $result = $array->fetchAll(PDO::FETCH_ASSOC);
        $result = (!empty($result)) ? $result : false;

        return $result;
    }
}