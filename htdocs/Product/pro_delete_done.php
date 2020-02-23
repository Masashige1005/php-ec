<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title></title>
</head>
<body>
	<?php
	try{
		$pro_code = $_POST['code'];
		$pro_image_name = $_POST['image_name'];

		// データベースへの接続
		$dsn = 'mysql:dbname=app-db;host=localhost;charset=utf8';
		$user = 'root';
		$password = '';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		// SQL文を使いレコードを変更
		$sql = 'DELETE FROM mst_product WHERE code=?';
		$stmt = $dbh->prepare($sql);
		$data[] = $pro_code;
		$stmt->execute($data);

		// データベースから切断（ここ重要）
		$dbh = null;

		if($pro_image_name != ''){
			unlink('./image/'.$pro_image_name);
		}
	}

	// データベースの障害が発生した時の処理
	catch (Exception $e){
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>
	削除しました。 <br />
	<br />
	<a href = "pro_list.php">戻る</a>

</body>
</html>
