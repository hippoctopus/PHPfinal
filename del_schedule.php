<?php
require_once('connection.php');
if (!isset($_GET['id'])) {
	header('Location: index.php');
	exit();
}

$sql = 'SELECT * FROM `Schedule` WHERE sid = :sid';
$sth = $db->prepare($sql);
$sth->bindParam(':sid', $_GET['id']);
$sth->execute();
$place = $sth->fetch();

if ($place['uid'] != $_SESSION['uid'] && !$_SESSION['is_admin']) {
	header('Location: index.php');
	exit();
}

$sql = 'DELETE FROM Schedule WHERE sid = :sid';
$sth = $db->prepare($sql);
$sth->bindParam(':sid', $_GET['id']);
$sth = $sth->execute();

header('Location: my_schedule.php');
