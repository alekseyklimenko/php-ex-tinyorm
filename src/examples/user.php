<?php
include_once('../TinyORM/Entity/User.php');
include_once('../TinyORM/Mapper/User.php');

$db = new \PDO('mysql:host=localhost;dbname=app','root','');
$userData = $db->query('SELECT * FROM users WHERE id=1')->fetch();

$user = new TinyORM\Entity\User();
$userMapper = new TinyORM\Mapper\User();
$user = $userMapper->populate($userData, $user);

echo $user->assembleDisplayName();
