<?php
session_start();
// 現在のセッションIDを 新しいものと置き換える。その際、現在のセッション情報は維持
session_regenerate_id(true);
if(isset($_SESSION['login'])==FALSE){
	print 'ログインされていません。<br />';
	print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
	exit();
} else {
	print $_SESSION['staff_name'];
	print 'さんログイン中<br />';
	print '<br />';
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title></title>
</head>
<body>
	<?php
	try{
		$staff_name = $_POST['name'];
		$staff_pass = $_POST['pass'];

		// 入力情報の安全対策
		$staff_name = htmlspecialchars($staff_name,ENT_QUOTES,'UTF-8');
		$staff_pass = htmlspecialchars($staff_pass,ENT_QUOTES,'UTF-8');

		// データベースへの接続
		$dsn = 'mysql:dbname=app-db;host=localhost;charset=utf8';
		$user = 'root';
		$password = '';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		// SQLを使いレコードを追加
		$sql = 'INSERT INTO mst_staff(name,password)VALUES(?,?)';
		$stmt = $dbh->prepare($sql);
		$data[] = $staff_name;
		$data[] = $staff_pass;
		$stmt->execute($data);

		// データベースから切断（ここ重要）
		$dbh = null;

		print $staff_name;
		print 'さんを追加しました。<br />';
	}

	// データベースの障害が発生した時の処理
	catch (Exception $e){
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>
	<a href = "staff_list.php">戻る</a>

</body>
</html>
