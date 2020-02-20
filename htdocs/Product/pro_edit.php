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
	$sql = 'SELECT name,price FROM mst_product WHERE code=?';
	$stmt = $dbh->prepare($sql);
	$data[] = $pro_code;
	$stmt->execute($data);

	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	$pro_name = $rec['name'];
	$pro_price = $rec['price'];

	$dbh = null;
	}

	// データベースの障害が発生した時の処理
	catch (Exception $e){
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>

	商品修正<br />
	<br />
	商品コード<br />
	<?php print $pro_code; ?>
	<br />
	<br />
	<form method = "post" action = "pro_edit_check.php">
		<input type = "hidden" name = "code" value = "<?php print $pro_code;?>">
		商品名<br />
		<input type = "text" name = "name" style = "width:200px" value = "<?php print $pro_name; ?>"><br />
		価格を入力してください。<br />
		<input type = "price" name = "price" style = "width:50px" value = "<?php print $pro_price ?>">円<br />
		<br />
		<input type = "button" onclick = "history.back()" value = "戻る">
		<input type = "submit" value = "OK">
	</form>
</body>