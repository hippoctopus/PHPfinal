<?php
require_once('connection.php');

$sql = 'SELECT * FROM `Schedule` WHERE is_private = 0 ORDER BY DATE';
$sth = $db->prepare($sql);
$sth->execute();
$schedules = $sth->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>排行程幫手</title>
</head>
<body style="margin:0;padding:0">
	<header>
		<?php if ($_SESSION['User_account']) {
			echo '<div style="text-align: right">您好' . $_SESSION['User_account'];
			echo '，<a href="logout.php">登出</a>? | ';
			echo '<a href="my_schedule.php">我的行程</a> | ';
			echo '<a href="index.php">回首頁</a>';
			echo '</div>';
		} else {
			echo '<div style="text-align: right">您好訪客，<a href="login.php">現在登入</a>?</div>';
		}?>
	</header>

	<center style="padding-bottom: 80px">
		<h1>排行程幫手</h1>
		<h2>查詢公開行程</h2>
		<form method="get" action="search.php">
			<input type="text" name="s" placeholder="查詢地點...">
			<input type="submit" value="搜尋">
		</form>
		<h2>最新公開行程</h2>
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
		<h2>最受歡迎的地點</h2>
		<?php
			$sql = 'SELECT name, COUNT(*) as times FROM Place GROUP BY Name ORDER BY COUNT(*) DESC LIMIT 1';
			$sth = $db->prepare($sql);
			$sth->execute();
			$place = $sth->fetch();
			echo '<div>' . $place['name'] . '已有 ' . $place['times'] . ' 次造訪</div>';
		?>
	</center>
	<footer style="position: fixed; bottom: 0;left: 0; width: 100%; padding: 20px 0; margin: 20px 0 0 0; background: #ccc; text-align: center; font-size: 11px; color: #333">
	2019 我愛丁丁 請讓我過　　2020 拒絕發財 一個臺灣
	</footer>
</body>
</html>