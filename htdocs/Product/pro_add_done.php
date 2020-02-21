<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title></title>
</head>
<body>
	<?php
	try{
		$pro_name = $_POST['name'];
		$pro_price = $_POST['price'];
		$pro_image_name = $_POST['image_name'];

		// 入力情報の安全対策
		$pro_name = htmlspecialchars($pro_name,ENT_QUOTES,'UTF-8');
		$pro_price = htmlspecialchars($pro_price,ENT_QUOTES,'UTF-8');

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
