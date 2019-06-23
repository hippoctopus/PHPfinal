<?php
require_once('connection.php');

if (!isset($_SESSION['User_account'])) {
	header('Location: index.php');
	exit();
}

$sql = 'SELECT * FROM `Schedule` WHERE uid = :uid ORDER BY DATE';
$sth = $db->prepare($sql);
$sth->bindParam(':uid', $_SESSION['uid']);
$sth->execute();
$schedules = $sth->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>我的行程</title>
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
	<h1>我的行程</h1>
		<a href="add_schedule.php">新增行程</a>
		<table style="border-collapse: collapse;" border="1">
			<thead>
				<tr>
					<th>時間</th>
					<th>行程</th>
					<th>查看</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach($schedules as $schedule){
					echo '<tr>';
					echo '<td>' . $schedule['date'] . '</td>';
					echo '<td>' . $schedule['name'] . '</td>';
					echo '<td><a href="schedule.php?id=' . $schedule['sid'] . '">查看</a></td>';
					echo '</tr>';
				}
			?>
			</tbody>
		</table>
	</center>
	<footer style="position: fixed; bottom: 0;left: 0; width: 100%; padding: 20px 0; margin: 20px 0 0 0; background: #ccc; text-align: center; font-size: 11px; color: #333">
	2019 我愛丁丁 請讓我過　　2020 拒絕發財 一個臺灣
	</footer>
</body>
</html>