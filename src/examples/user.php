<?php
// A self-made ORM
include_once('../TinyORM/Entity/User.php');
include_once('../TinyORM/Mapper/User.php');
include_once('../TinyORM/EntityManager.php');

// get user from database
$db = new \PDO('mysql:host=localhost;dbname=app','root','');
$userData = $db->query('SELECT * FROM users WHERE id=1')->fetch();

$user = new TinyORM\Entity\User();
$userMapper = new TinyORM\Mapper\User();
$user = $userMapper->populate($userData, $user);

echo $user->assembleDisplayName();

//the same using repository
$em = new EntityManager('localhost', 'app', 'root', '');
$user = $em->getUserRepository()->findOneById(1);
echo $user->assembleDisplayName();
$user->setFirstName('Alex');
$em->saveUser($user);

//add a new record
$newUser = new TinyORM\Entity\User();
$newUser->setFirstName('Ivan');
$newUser->setLastName('Ivanov');
$newUser->setGender(1);
$em->saveUser($newUser);
echo $newUser->assembleDisplayName();

//show user posts
foreach ($user->getPosts() as $post) {
    echo $post->getTitle() . "\n";
}
