<?php
include_once('Repository/User.php');

use TinyORM\Repository\User as UserRepository;
use TinyORM\Mapper\User as UserMapper;
use TinyORM\Entity\User as UserEntity;
use TinyORM\Repository\Post as PostRepository;

class EntityManager
{
    private $host;
    private $db;
    private $user;
    private $pwd;
    /** @var \PDO */
    private $connection;
    private $userRepository;
    private $postRepository;
    private $identityMap;

    public function __construct($host, $db, $user, $pwd)
    {
        $this->host = $host;
        $this->db = $db;
        $this->user = $user;
        $this->pwd = $pwd;
        $this->connection = new \PDO("mysql:host=$host;dbname=$db", $user, $pwd);
        $this->userRepository = null;
        $this->identityMap = ['users' => []];
    }

    public function query($stmt)
    {
        return $this->connection->query($stmt);
    }

    public function saveUser(UserEntity $user)
    {
        $userMapper = new UserMapper();
        $data = $userMapper->extract($user);
        $idcol = $userMapper->getIdColumn();
        $userId = call_user_func([$user, 'get' . ucfirst($idcol)]);
        if (array_key_exists($userId, $this->identityMap['users'])) {
            $setStr = '';
            foreach ($data as $key => $value) {
                $setStr .= $key . "='{$value}',";
            }
            $setStr = substr($setStr, 0, -1);
            $query = "UPDATE users SET {$setStr} WHERE {$idcol}={$userId}";
        } else {
            $columnsString = implode(', ', array_keys($data));
            $valuesString = implode("', '", array_map('mysql_real_escape_string', $data));
            $query = "INSERT INTO users ($columnsString) VALUES('$valuesString')";
        }
        return $this->query($query);
    }

    public function getUserRepository()
    {
        if (is_null($this->userRepository)) {
            $this->userRepository = new UserRepository($this);
        }
        return $this->userRepository;
    }

    public function getPostRepository()
    {
        if (is_null($this->postRepository)) {
            $this->postRepository = new PostRepository($this);
        }
        return $this->postRepository;
    }

    public function registerUserEntity($id, $user)
    {
        $this->identityMap['users'][$id] = $user;
        return $user;
    }

    public function getUserEntity($id)
    {
        if (isset($this->identityMap['users'][$id])) {
            return $this->identityMap['users'][$id];
        }
        return null;
    }
}
