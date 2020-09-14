<?php

class Database extends PDO
{

    protected static $_instance = null;

    protected $db_host = 'localhost';
    protected $db_name = 'testbase';
    protected $db_user = 'test';
    protected $db_pass = 'test';

    public function __construct() {
        return $this->connection();
    }

    public function connection() {
        try {
            parent::__construct("mysql:host={$this->db_host};dbname={$this->db_name};charset=utf8", $this->db_user, $this->db_pass);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>