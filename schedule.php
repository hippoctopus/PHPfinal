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

if (!$schedule) {
	header('Location: index.php');
	exit();
}

$sql = 'SELECT * FROM `Place` WHERE sid = :sid ORDER BY time';
$sth = $db->prepare($sql);
$sth->bindParam(':sid', $_GET['id']);
$sth->execute();
$places = $sth->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>行程列表</title>
</head>
<body style="margin:0;padding:0">
	<?php if ($_SESSION['User_account']) {
		echo '<div style="text-align: right">您好' . $_SESSION['User_account'];
		echo '，<a href="logout.php">登出</a>? | ';
		echo '<a href="my_schedule.php">我的行程</a> | ';
		echo '<a href="index.php">回首頁</a>';
		echo '</div>';
	} else {
		echo '<div style="text-align: right">您好訪客，<a href="login.php">現在登入</a>?</div>';
	}?>
	<center style="padding-bottom: 80px">
		<h2>旅程資訊</h2>
		<div>旅程名稱：<?php echo $schedule['name'] ?></div>
		<div>旅程日期：<?php echo $schedule['date'] ?></div>
		<h2>詳細行程</h2>
		<table style="border-collapse: collapse;" border="1">
			<thead>
				<tr>
					<th>時間</th>
					<th>地點</th>
					<?php
						if ($schedule['uid'] === $_SESSION['uid'] || $_SESSION['is_admin']) {
							echo '<th>刪除</th>';
						}
					?>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach($places as $place){
					echo '<tr>';
					echo '<td>' . $place['time'] . '</td>';
					echo '<td>' . $place['name'] . '</td>';
					if ($schedule['uid'] === $_SESSION['uid'] || $_SESSION['is_admin']) {
						echo '<td><a href="del_place.php?id=' . $place['pid'] . '">不去了</a></td>';
					}
					echo '</tr>';
				}
			?>
			</tbody>
		</table>

		<?php
		if ($schedule['uid'] === $_SESSION['uid']) { ?>
			<h2>新增景點</h2>
			<form method="POST" action="add_place.php?id=<?php echo $_GET['id'];?>">
				<div>
					景點名稱 <input type="text" name="name" style="width: 200px">
				</div>
				<div>
					時　　間 <input type="time" name="time" style="width: 200px">
				</div>
				<div>
					<input type="submit" value="新增">
				</div>
			</form>
		<?php
		}
		if ($schedule['uid'] === $_SESSION['uid'] || $_SESSION['is_admin']) { ?>
			<h2>刪除此行程表</h2>
			<a href="del_schedule.php?id=<?php echo $_GET['id']; ?>" style="color:red">我要刪除行程</a>
		<?php } ?>
	</center>
	<footer style="position: fixed; bottom: 0;left: 0; width: 100%; padding: 20px 0; margin: 20px 0 0 0; background: #ccc; text-align: center; font-size: 11px; color: #333">
	2019 我愛丁丁 請讓我過　　2020 拒絕發財 一個臺灣
	</footer>
</body>
</html>