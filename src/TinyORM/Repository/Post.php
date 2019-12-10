<?php
namespace TinyORM\Repository;

include_once('../Entity/Post.php');
include_once('../Mapper/Post.php');
include_once('../Entity/User.php');

use TinyORM\Entity\Post as PostEntity;
use TinyORM\Entity\User as UserEntity;
use TinyORM\Mapper\Post as PostMapper;

class Post
{
    /** @var \EntityManager */
    private $em;
    private $mapper;

    public function __construct(\EntityManager $em)
    {
        $this->em = $em;
        $this->mapper = new PostMapper();
    }

    public function findByUser(UserEntity $user)
    {
        $postsData = $this->em->query("SELECT * FROM posts WHERE user_id={$user->getId()}")->fetchAll();
        $posts = [];
        foreach ($postsData as $data) {
            $posts[] = $this->mapper->populate($data, new PostEntity());
        }
        return $posts;
    }
}
