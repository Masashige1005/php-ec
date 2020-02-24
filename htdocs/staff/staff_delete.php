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
		$staff_code = $_GET['staffcode'];
		// データベースへの接続
		$dsn = 'mysql:dbname=app-db;host=localhost;charset=utf8';
		$user = 'root';
		$password = '';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		// データベースから選択された名前を取得
		$sql = 'SELECT name FROM mst_staff WHERE code=?';
		$stmt = $dbh->prepare($sql);
		$data[] = $staff_code;
		$stmt->execute($data);

		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		$staff_name = $rec['name'];

		$dbh = null;
	}

	// データベースの障害が発生した時の処理
	catch (Exception $e){
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>

	スタッフ削除<br />
	<br />
	スタッフコード<br />
	<?php print $staff_code; ?>
	<br />
	スタッフ名<br />
	<?php print $staff_name; ?>
	<br />
	このスタッフを削除しても宜しいですか？<br />
	<br />
	<form method = "post" action = "staff_delete_done.php">
		<input type = "hidden" name = "code" value = "<?php print $staff_code?>"><br />
		<input type = "button" onclick = "history.back()" value = "戻る">
		<input type = "submit" value = "OK">
	</form>
</body>