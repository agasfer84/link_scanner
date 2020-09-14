<?php
require_once(__DIR__."/Database.php");

class Links
{
    private $db;
    private $table = 'link_files';

    public function __construct()
    {
        $db = new Database();
        $this->db = $db;
    }

    public function create($link, $file_id)
    {
        $connection = $this->db;

        $query = "INSERT INTO $this->table (link, file_id) VALUES (:link, :file_id)";
        $result = $connection->prepare($query);
        $result->execute(["link" => $link, "file_id" => $file_id]);
    }

    public function getAll()
    {
        $connection = $this->db;

        $query = "SELECT * FROM $this->table";
        $result = $connection->prepare($query);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

}