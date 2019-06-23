<?php
require_once('connection.php');


if ($_POST['name'] && $_POST['date']) {
	$is_private = 0;
	if (isset($_POST['is_private'])) {
		$is_private = 1;
	}

	$sql = 'INSERT INTO `Schedule` (`date`, `name`, `uid`, `is_private`) VALUES (:date, :name, :uid, :is_private)';
	$sth = $db->prepare($sql);
	$sth->bindParam(':date', $_POST['date']);
	$sth->bindParam(':name', $_POST['name']);
	$sth->bindParam(':uid', $_SESSION['uid']);
	$sth->bindParam(':is_private', $is_private);
	$sth = $sth->execute();

	header('Location: schedule.php?id=' . $db->lastInsertId());

} else if (count($_POST) > 0) {
	$fail = '請填好資料';
	echo count($_POST);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>新增行程表</title>
</head>
<body style="margin:0;padding:0">
	<center style="padding-bottom: 80px">
		<h1>新增行程表</h1>
		<form method="post" action="add_schedule.php">
			<?php if ($fail) echo '<p style="color: red">'.$fail.'</p>'; ?>
			<div>
				旅程名稱 <input type="text" name="name" style="width: 200px">
			</div>
			<div>
				出遊日期 <input type="date" name="date" style="width: 200px">
			</div>
			<div>
				<input type="checkbox" name="is_private" value="private"> 這是私人行程
			</div>
			<div>
				<input type="submit" value="下一步">
			</div>
		</form>
	</center>
</body>
</html>