<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login']) == FALSE){
	print 'ようこそ、ゲスト様';
	print '<a href="member_login.html">会員ログイン</a><br />';
	print '<br />';
} else {
	print 'ようこそ';
	print $_SESSION['member_name'];
	print '様';
	print '<a href="member_logout.html">ログアウト</a><br />';
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
		$cart = $_SESSION['cart'];
		$quan = $_SESSION['quan'];
		$max = count($cart);
		// データベースへの接続
		$dsn = 'mysql:dbname=app-db;host=localhost;charset=utf8';
		$user = 'root';
		$password = '';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		foreach($cart as $key => $val){
			$sql = 'SELECT code,name,price,image FROM mst_product WHERE code=?';
			$stmt = $dbh->prepare($sql);
			$data[0] = $val;
			$stmt -> execute($data);

			$rec = $stmt ->fetch(PDO::FETCH_ASSOC);
			$pro_name[] = $rec['name'];
			$pro_price[] = $rec['price'];
			if($rec['image'] == ''){
				$pro_image[] = '';
			} else {
				$pro_image[] = '<img src="../product/image/'.$rec['image'].'">';
			}
		}
		$dbh = null;
	}

	// データベースの障害が発生した時の処理
	catch (Exception $e){
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>
	カートの中身<br />
	<br />
	<form method = "post" action = "quan_change.php">
	<?php for($i=0;$i<$max;$i++){ ?>
		<?php print $pro_name[$i]; ?>
		<?php print $pro_image[$i]; ?>
		<?php print $pro_price[$i].'円'; ?>
		<input type = "text" name = "quan<?php print $quan[$i]; ?>" value = "<?php print $quan[$i]; ?>" ?>
		<?php print '<br />'; ?>
	<?php } ?>
		<input type = "hidden" name = "max" value = "<?php print $max; ?>">
		<input type = "submit" value = "数値変更">
		<input type = "button" onclick = "history.back()" value = "戻る">
	</form>
</body>
</html>