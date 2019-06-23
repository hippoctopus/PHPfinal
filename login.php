<?php
require_once('connection.php');


if ($_POST['user'] && $_POST['pass']) {
	$sql = 'SELECT * FROM `Member` WHERE User_account = :User_account AND User_password = :User_password';
	$sth = $db->prepare($sql);
	$sth->bindParam(':User_account', $_POST['user']);
	$sth->bindParam(':User_password', $_POST['pass']);
	$sth->execute();
	$user = $sth->fetch();

	if ($user) {
		$_SESSION['User_account'] = $_POST['user'];
		$_SESSION['uid'] = (int) $user['Uid'];

		if ($user['Is_admin']) {
			$_SESSION['is_admin'] = true;
			header('Location: admin.php');
		} else {
			header('Location: index.php');
		}
	} else {
		$fail = true;
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>登入</title>
</head>
<body style="margin:0;padding:0">
	<center style="padding-bottom: 80px">
		<h1>登入 排行程幫手</h1>
		<form method="post" action="login.php">
			<?php if ($fail) echo '<p style="color: red">登入錯誤</p>'; ?>
			<div>
				帳號 <input type="text" name="user">
			</div>
			<div>
				密碼 <input type="password" name="pass">
			</div>
			<div>
				<input type="submit" value="登入">
			</div>
			<div>
				<small>沒有帳號嗎？<a href="register.php">現在註冊</a>！</small>
			</div>
		</form>
	</center>
</body>
</html>