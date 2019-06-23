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
$schedule = $sth->fetch();

if ($schedule['uid'] != $_SESSION['uid']) {

	header('Location: index.php');
	exit();
}

if ($_POST['name'] && $_POST['time']) {
	$sql = 'INSERT INTO `Place` (`name`, `time`, `sid`, `uid`) VALUES (:name, :time, :sid, :uid)';
	$sth = $db->prepare($sql);
	$sth->bindParam(':name', $_POST['name']);
	$sth->bindParam(':time', $_POST['time']);
	$sth->bindParam(':sid', $_GET['id']);
	$sth->bindParam(':uid', $_SESSION['uid']);
	$sth = $sth->execute();

}

header('Location: schedule.php?id=' . $_GET['id']);
