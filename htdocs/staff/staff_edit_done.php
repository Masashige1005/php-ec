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
		$post = sanitize($_POST);
		$staff_code = $post['code'];
		$staff_name = $post['name'];
		$staff_pass = $post['pass'];

		require_once('../common/common.php')

		// データベースへの接続
		$dsn = 'mysql:dbname=app-db;host=localhost;charset=utf8';
		$user = 'root';
		$password = '';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		// SQL文を使いレコードを変更
		$sql = 'UPDATE mst_staffs SET name=?,password=? WHERE code=?';
		$stmt = $dbh->prepare($sql);
		$data[] = $staff_name;
		$data[] = $staff_pass;
		$data[] = $staff_code;
		$stmt->execute($data);

		// データベースから切断（ここ重要）
		$dbh = null;
	}

	// データベースの障害が発生した時の処理
	catch (Exception $e){
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>
	修正しました。 <br />
	<br />
	<a href = "staff_list.php">戻る</a>

</body>
</html>
