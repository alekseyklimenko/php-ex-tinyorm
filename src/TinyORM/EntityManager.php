<?php
include_once('Repository/User.php');

use TinyORM\Repository\User as UserRepository;

class EntityManager
{
    private $host;
    private $db;
    private $user;
    private $pwd;
    /** @var \PDO */
    private $connection;
    private $userRepository;

    public function __construct($host, $db, $user, $pwd)
    {
        $this->host = $host;
        $this->db = $db;
        $this->user = $user;
        $this->pwd = $pwd;
        $this->connection = new \PDO("mysql:host=$host;dbname=$db", $user, $pwd);
        $this->userRepository = null;
    }

    public function query($stmt)
    {
        return $this->connection->query($stmt);
    }

    public function getUserRepository()
    {
        if (is_null($this->userRepository)) {
            $this->userRepository = new UserRepository($this);
        }
        return $this->userRepository;
    }
}
