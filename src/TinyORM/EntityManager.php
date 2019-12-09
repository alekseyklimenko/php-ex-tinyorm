<?php
include_once('Repository/User.php');

use TinyORM\Repository\User as UserRepository;
use TinyORM\Mapper\User as UserMapper;
use TinyORM\Entity\User as UserEntity;

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

    public function saveUser(UserEntity $user)
    {
        $userMapper = new UserMapper();
        $data = $userMapper->extract($user);
        $columnsString = implode(', ', array_keys($data));
        $valuesString = implode("', '", array_map('mysql_real_escape_string', $data));
        return $this->query("INSERT INTO users ($columnsString) VALUES('$valuesString')");
    }

    public function getUserRepository()
    {
        if (is_null($this->userRepository)) {
            $this->userRepository = new UserRepository($this);
        }
        return $this->userRepository;
    }
}
