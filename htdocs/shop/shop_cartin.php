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
		// カートの中身を確認
		if(isset($_SESSION['cart'])==true){
			// カートの内容をコピー
			$cart = $_SESSION['cart'];
			$quan = $_SESSION["quan"];
		}
		// カートに商品を追加
		$cart[] = $pro_code;
		$quan[] = 1;
		$_SESSION['cart'] = $cart;
		$_SESSION['quan'] = $quan;
	}
	// データベースの障害が発生した時の処理
	catch (Exception $e){
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>

	カートに追加しました。<br />
	<br />
	<a href = "shop_list.php">商品一覧に戻る</a>

	商品情報参照<br />
	<br />
	商品コード<br />
	<?php print $pro_code;?>
	<br />
	<form>
		<input type = "button" onclick = "history.back()" value = "戻る">
	</form>
</body>
</html>