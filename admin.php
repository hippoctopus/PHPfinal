<?php
require_once('connection.php');

$sql = 'SELECT * FROM `Member` WHERE uid = :uid';
$sth = $db->prepare($sql);
$sth->bindParam(':uid', $_SESSION['uid']);
$sth->execute();
$user = $sth->fetch();

if (!$user['Is_admin']) {
	header('Location: index.php');
	exit();
}


$sql = 'SELECT Schedule.*, Member.User_account FROM Member Member, Schedule Schedule WHERE Schedule.uid = Member.Uid; ORDER BY DATE';
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
	<title>管理頁面</title>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
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
		<h1>管理頁面</h1>
		<h2>全站所有行程</h2>
		<table style="border-collapse: collapse;" border="1">
			<thead>
				<tr>
					<th>時間</th>
					<th>行程</th>
					<th>使用者</th>
					<th>是否公開</th>
					<th>查看</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach($schedules as $schedule){
					echo '<tr>';
					echo '<td>' . $schedule['date'] . '</td>';
					echo '<td>' . $schedule['name'] . '</td>';
					echo '<td>' . $schedule['User_account'] . '</td>';
					echo '<td>' . ($schedule['is_private'] == 1 ? '公開' : '私人') . '</td>';
					echo '<td><a href="schedule.php?id=' . $schedule['sid'] . '">查看</a></td>';
					echo '</tr>';
				}
			?>
			</tbody>
		</table>
		<h2>不同時段旅遊數</h2>
		<canvas id="chart1" style="max-width: 500px"></canvas>
		<?php
			$sql = 'SELECT SUBSTRING(time, 1, 2) as hour, COUNT(*) as times FROM Place GROUP BY SUBSTRING(time, 1, 2) order by SUBSTRING(time, 1, 2)';
			$sth = $db->prepare($sql);
			$sth->execute();
			$count = $sth->fetchAll(PDO::FETCH_KEY_PAIR);

			$data = array();
			for($i=0;$i<24;$i++) {

				$hour = str_pad($i, 2, '0', STR_PAD_LEFT);

				array_push($data, ($count[$hour]) ? (int) $count[$hour] : 0);
			}
		?>
		<script>
			var randomColorGenerator = function () {
				return '#' + (Math.random().toString(16) + '0000000').slice(2, 8); 
			};
			var ctx = document.getElementById('chart1').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'],
					datasets: [{
						label: '各時段出遊人數',
						backgroundColor: randomColorGenerator(),
						data: <?php echo json_encode($data); ?>
					}]
				},
				options: {}
			});
		</script>


		<h2>熱門景點</h2>
		<canvas id="chart2" style="max-width: 500px"></canvas>
		<?php
			$sql = 'SELECT name, COUNT(*) as times FROM Place GROUP BY Name ORDER BY COUNT(*) DESC LIMIT 10';
			$sth = $db->prepare($sql);
			$sth->execute();
			$count = $sth->fetchAll();

			$names = array();
			$times = array();

			foreach($count as $place) {
				array_push($names, $place['name']);
				array_push($times, $place['times']);
			}
		?>
		<script>
			var ctx = document.getElementById('chart2').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: <?php echo json_encode($names); ?>,
					datasets: [{
						label: '熱門景點',
						backgroundColor:　randomColorGenerator(),
						data: <?php echo json_encode($times); ?>
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			});
		</script>


		<h2>全站年齡層旅遊次數</h2>
		<canvas id="chart3" style="max-width: 500px"></canvas>
		<?php
			$sql = 'SELECT Member.User_age as age, COUNT(*) as times FROM Schedule Schedule, Member Member WHERE Schedule.uid = Member.Uid group by Member.User_age';
			$sth = $db->prepare($sql);
			$sth->execute();
			$count = $sth->fetchAll();

			$age = array();
			$times = array();

			foreach($count as $place) {
				array_push($age, $place['age']);
				array_push($times, $place['times']);
			}
		?>
		<script>
			var ctx = document.getElementById('chart3').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'pie',
				data: {
					labels: <?php echo json_encode($age); ?>,
					datasets: [{
						label: '年齡層旅遊次數',
						backgroundColor: Array(<?php echo count($times); ?>).fill(0).map(x => randomColorGenerator()),
						data: <?php echo json_encode($times); ?>
					}]
				},
				options: {}
			});
		</script>
	</center>
	<footer style="position: fixed; bottom: 0;left: 0; width: 100%; padding: 20px 0; margin: 20px 0 0 0; background: #ccc; text-align: center; font-size: 11px; color: #333">
	2019 我愛丁丁 請讓我過　　2020 拒絕發財 一個臺灣
	</footer>
</body>
</html>