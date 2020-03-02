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
		if(isset($_SESSION['cart']) == TRUE){
			$cart = $_SESSION['cart'];
			$quan = $_SESSION['quan'];
			$max = count($cart);
		} else{
			// カートが空の状態でカートの中身を見たときは中身を0にする
			$max = 0;
		}

		if($max == 0){
			print 'カートに商品が入っていません。<br />';
			print '<br />';
			print '<a href="shop_list.php">商品一覧に戻る</a>';
			exit();
		}
		// データベースへの接続
		$dsn = 'mysql:dbname=app-db;host=localhost;charset=utf8';
		$user = 'root';
		$password = '';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		foreach($cart as $key => $val){
			$sql = 'SELECT code,name,price,image FROM mst_products WHERE code=?';
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
		<table border = "1">
			<tr>
				<td>商品</td>
				<td>商品画像</td>
				<td>価格</td>
				<td>数量</td>
				<td>小計</td>
				<td>削除</td>
			</tr>
			<?php for($i=0;$i<$max;$i++){ ?>
			<tr>
				<td><?php print $pro_name[$i]; ?></td>
				<td><?php print $pro_image[$i]; ?></td>
				<td><?php print $pro_price[$i].'円'; ?></td>
				<td><input type = "text" name = "quan<?php print $i;?>" value = "<?php print $quan[$i];?>"></td>
				<td><?php print $pro_price[$i]*$quan[$i];?>円</td>
				<td><input type = "checkbox" name = "delete<?php print $i;?>"></td>
				<?php print '<br />'; ?>
			</tr>
			<?php } ?>
		</table>
			<input type = "hidden" name = "max" value = "<?php print $max; ?>">
			<input type = "submit" value = "数値変更">
			<input type = "button" onclick = "history.back()" value = "戻る">
	</form>
	<br />
	<a href = "shop_form.html">購入手続きへ進む</a><br />
	<?php
	if(isset($_SESSION["member_login"]) == true){
		print '<a href="shop_easy_check.php">会員簡単注文へ進む</a><br />';
	}
	?>
</body>
</html>