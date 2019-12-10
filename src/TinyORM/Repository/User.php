<?php
namespace TinyORM\Repository;

include_once('../Entity/User.php');
include_once('../Mapper/User.php');

use TinyORM\Entity\User as UserEntity;
use TinyORM\Mapper\User as UserMapper;

class User
{
    /** @var \EntityManager */
    private $em;
    private $mapper;

    public function __construct(\EntityManager $em)
    {
        $this->em = $em;
        $this->mapper = new UserMapper();
    }

    public function findOneById($id)
    {
        $user = $this->em->getUserEntity($id);
        if (!$user) {
            $userData = $this->em->query('SELECT * FROM users WHERE id=' . $id)->fetch();
            $user = new UserEntity();
            $user->setPostRepository($this->em->getPostRepository());
            $this->em->registerUserEntity($id, $this->mapper->populate($userData, $user));
        }
        return $user;
    }
}
