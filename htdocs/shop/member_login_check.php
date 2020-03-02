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
		$member_email = $post['email'];
		$member_pass = $post['pass'];

		$staff_pass = md5($staff_pass);

		$dsn = 'mysql:dbname=app-db;host=localhost;charset=utf8';
		$user = 'root';
		$password = '';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		$sql = 'SELECT code,name FROM dat_member WHERE email=? AND password=?';
		$stmt = $dbh->prepare($sql);
		$data[] = $member_email;
		$data[] = $member_pass;
		$stmt->execute($data);

		$dbh = null;
		$rec = $stmt->fetch(PDO::FETCH_ASSOC);

		if($rec == false){
			print 'メールアドレスまたはパスワードが間違えています。<br />';
			print '<a href="member_login.html">戻る</a>';
		} else {
			// ユーザー認証
			session_start();
			// 1の状態がログインOK!
			$_SESSION['member_login'] = 1;
			$_SESSION['member_code'] = $$rec['code'];
			$_SESSION['staff_name'] = $rec['name'];
			header('Location:shop_list.php');
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
