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
		$sql = 'SELECT code,name,price FROM mst_product WHERE 1';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		// データベースから切断
		$dbh = null;

		print '商品一覧 <br /><br />';

		print '<form method = "post" action ="pro_branch.php">';
		while(true){
			$rec = $stmt->fetch(PDO::FETCH_ASSOC);
			if($rec == FALSE){
				break;
			}
			// 商品を選んだ際に飛び先がわかるようにコードを渡しています。
			print '<input type = "radio" name = "procode" value = "'.$rec['code'].'">';
			print $rec['name'].'---';
			print $rec['price'].'円';
			print '<br />';
		}
		print '<input type = "submit" name = "disp" value = " 参照">';
		print '<input type = "submit" name = "add" value = " 追加">';
		print '<input type = "submit" name = "edit" value = "修正">';
		print '<input type = "submit" name = "delete" value = "削除">';
		print '</form>';
	}
	// データベースの障害が発生した時の処理
	catch (Exception $e){
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>
</body>