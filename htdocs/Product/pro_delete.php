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
		$pro_code = $_GET['procode'];
		// データベースへの接続
		$dsn = 'mysql:dbname=app-db;host=localhost;charset=utf8';
		$user = 'root';
		$password = '';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		// データベースから選択された名前を取得
		$sql = 'SELECT name,image FROM mst_products WHERE code=?';
		$stmt = $dbh->prepare($sql);
		$data[] = $pro_code;
		$stmt->execute($data);

		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		$pro_name = $rec['name'];
		$pro_image_name = $rec['image'];

		$dbh = null;

		if($pro_image_name == ''){
			$disp_image = '';
		} else {
			$disp_image = '<img src = "./image/'.$pro_image_name.'">';
		}
	}

	// データベースの障害が発生した時の処理
	catch (Exception $e){
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>

	商品削除<br />
	<br />
	商品コード<br />
	<?php print $pro_code; ?>
	<br />
	商品名<br />
	<?php print $pro_name; ?>
	<br />
	<?php print $disp_image; ?>
	<br />
	この商品を削除しても宜しいですか？<br />
	<br />
	<form method = "post" action = "pro_delete_done.php">
		<input type = "hidden" name = "code" value = "<?php print $pro_code?>"><br />
		<input type = "hidden" name = "image_name" value = "<?php print $pro_image_name?>"><br />
		<input type = "button" onclick = "history.back()" value = "戻る">
		<input type = "submit" value = "OK">
	</form>
</body>