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
		require_once('../common/common.php');

		$post = sanitize($_POST);
		$pro_name = $post['name'];
		$pro_price = $post['price'];
		$pro_image_name = $post['image_name'];

		// データベースへの接続
		$dsn = 'mysql:dbname=app-db;host=localhost;charset=utf8';
		$user = 'root';
		$password = '';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		// SQLを使いレコードを追加
		$sql = 'INSERT INTO mst_product(name,price,image)VALUES(?,?,?)';
		$stmt = $dbh->prepare($sql);
		$data[] = $pro_name;
		$data[] = $pro_price;
		$data[] = $pro_image_name;
		$stmt->execute($data);

		// データベースから切断（ここ重要）
		$dbh = null;

		print $pro_name;
		print 'を追加しました。<br />';
	}

	// データベースの障害が発生した時の処理
	catch (Exception $e){
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>
	<a href = "pro_list.php">戻る</a>

</body>
</html>
