<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title></title>
</head>
<body>
	<?php
	try{
		require_once('../common/common.php');
		$post = sanitize($_POST);
		$staff_code = $post['code'];
		$staff_pass = $post['pass'];

		$staff_pass = md5($staff_pass);

		$dsn = 'mysql:dbname=app-db;host=localhost;charset=utf8';
		$user = 'root';
		$password = '';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		$sql = 'SELECT name FROM mst_staffs WHERE code=? AND password=?';
		$stmt = $dbh->prepare($sql);
		$data[] = $staff_code;
		$data[] = $staff_pass;
		$stmt->execute($data);

		$dbh = null;
		$rec = $stmt->fetch(PDO::FETCH_ASSOC);

		if($rec == false){
			print 'スタッフコードまたはパスワードが間違えています。<br />';
			print '<a href="staff_login.html">戻る</a>';
		} else {
			// ユーザー認証
			session_start();
			// 1の状態がログインOK!
			$_SESSION['login'] = 1;
			$_SESSION['staff_code'] = $staff_code;
			$_SESSION['staff_name'] = $rec['name'];
			header('Location:staff_top.php');
			exit();
		}
	}
	catch (Exception $e){
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>
</body>
</html>
