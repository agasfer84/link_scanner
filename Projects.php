<?php
require_once(__DIR__."/Database.php");


class Projects
{

    private $db;
    private $table = 'link_projects';

    const NONCHECKED_STATUS = 0;
    const CHECKED_STATUS = 1;

    public function __construct()
    {
        $db = new Database();
        $this->db = $db;
    }

    public function getOne()
    {
        $connection = $this->db;

        $query = "SELECT * FROM $this->table WHERE status = :status";
        $result = $connection->prepare($query);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute(["status" => self::NONCHECKED_STATUS]);

        return $result->fetchAll(PDO::FETCH_ASSOC)[0];
    }

}