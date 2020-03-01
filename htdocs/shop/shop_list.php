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
		// データベースへの接続
		$dsn = 'mysql:dbname=app-db;host=localhost;charset=utf8';
		$user = 'root';
		$password = '';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		// データベースから名前を全て取得
		$sql = 'SELECT code,name,price FROM mst_products WHERE 1';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		// データベースから切断
		$dbh = null;

		print '商品一覧 <br /><br />';

		while(true){
			$rec = $stmt->fetch(PDO::FETCH_ASSOC);
			if($rec == FALSE){
				break;
			}
			// 商品を選んだ際に飛び先がわかるようにコードを渡しています。
			print '<a href="shop_product.php?procode='.$rec['code'].'">';
			print $rec['name'].'---';
			print $rec['price'].'円';
			print '</a>';
			print '<br />';
		}

		print '<br />';
		print '<a href="shop_cartlook.php">カートを見る</a><br />';
	}
	// データベースの障害が発生した時の処理
	catch (Exception $e){
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>
</body>