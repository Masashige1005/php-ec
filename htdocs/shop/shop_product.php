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
		$pro_code = $_GET['procode'];
		// データベースへの接続
		$dsn = 'mysql:dbname=app-db;host=localhost;charset=utf8';
		$user = 'root';
		$password = '';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		// データベースから選択された名前を取得
		$sql = 'SELECT name,price,image FROM mst_products WHERE code=?';
		$stmt = $dbh->prepare($sql);
		$data[] = $pro_code;
		$stmt->execute($data);

		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		$pro_name = $rec['name'];
		$pro_price = $rec['price'];
		$pro_image_name = $rec['image'];

		$dbh = null;
		if($pro_image_name == ''){
			$disp_image = '';
		} else {
			$disp_image = '<img src = "../product/image/'.$pro_image_name.'">';
		}
	print '<a href="shop_cartin.php?procode='.$pro_code.'">カートに入れる</a><br /><br />';
	}

	// データベースの障害が発生した時の処理
	catch (Exception $e){
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>

	商品情報参照<br />
	<br />
	商品コード<br />
	<?php print $pro_code; ?>
	<br />
	商品名<br />
	<?php print $pro_name; ?>
	<br />
	価格<br />
	<?php print $pro_price; ?> 円
	<br />
	<?php print $disp_image ?>
	<br />
	<br />
	<form>
		<input type = "button" onclick = "history.back()" value = "戻る">
	</form>
</body>
</html>