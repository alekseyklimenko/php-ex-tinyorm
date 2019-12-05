<?php
include('../TinyORM/Entity/User.php');

$db = new \PDO('mysql:host=localhost;dbname=app','root','');
$userData = $db->query('SELECT * FROM users WHERE id=1')->fetch();

$user = new TinyORM\Entity\User();
$user->setId($userData['id']);
$user->setFirstName($userData['first_name']);
$user->setLastName($userData['last_name']);
$user->setGender($userData['gender']);
$user->setNamePrefix($userData['name_prefix']);

echo $user->assembleDisplayName();
