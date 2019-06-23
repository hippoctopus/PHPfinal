<?php
require_once('connection.php');


if ($_POST['pass'] != $_POST['confirm_pass']) {
	$fail = '確認密碼錯誤';
} else if ($_POST['user'] && $_POST['pass'] && $_POST['age']) {
	$sql = 'INSERT INTO `Member` (`User_account`, `User_password`, `User_age`) VALUES (:User_account, :User_password, :User_age)';
	$sth = $db->prepare($sql);
	$sth->bindParam(':User_account', $_POST['user']);
	$sth->bindParam(':User_password', $_POST['pass']);
	$sth->bindParam(':User_age', $_POST['age']);
	$sth = $sth->execute();

	$_SESSION['User_account'] = $_POST['user'];
	$_SESSION['uid'] = $db->lastInsertId();
	header('Location: index.php');

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
	<title>註冊</title>
</head>
<body style="margin:0;padding:0">
	<center style="padding-bottom: 80px">
		<h1>註冊 排行程幫手</h1>
		<form method="post" action="register.php">
			<?php if ($fail) echo '<p style="color: red">'.$fail.'</p>'; ?>
			<div>
				帳　　號 <input type="text" name="user">
			</div>
			<div>
				密　　碼 <input type="password" name="pass">
			</div>
			<div>
				確認密碼 <input type="password" name="confirm_pass">
			</div>
			<div>
				年　　齡 <input type="number" name="age">
			</div>
			<div>
				<input type="submit" value="註冊">
			</div>
			<div>
				<small>已經有帳號嗎？<a href="login.php">現在登入</a>！</small>
			</div>
		</form>
	</center>
</body>
</html>