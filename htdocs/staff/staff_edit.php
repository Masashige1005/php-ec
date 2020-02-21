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

	// 配列のキー文字列として使って値を格納した配列を返す
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

	スタッフ修正<br />
	<br />
	スタッフコード<br />
	<?php print $staff_code; ?>
	<br />
	<br />
	<form method = "post" action = "staff_edit_check.php">
		<input type = "hidden" name = "code" value = "<?php print $staff_code;?>">
		スタッフ名<br />
		<input type = "text" name = "name" style = "width:200px" value = "<?php print $staff_name; ?>"><br />
		パスワードを入力してください。<br />
		<input type = "password" name = "pass" style = "width:100px"><br />
		パスワードをもう一度入力してください。<br />
		<input type = "password" name = "pass2" style = "width:100px"><br />
		<br />
		<input type = "button" onclick = "history.back()" value = "戻る">
		<input type = "submit" value = "OK">
	</form>
</body>