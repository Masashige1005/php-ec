<?php
session_start();
// 現在のセッションIDを 新しいものと置き換える。その際、現在のセッション情報は維持
session_regenerate_id(true);
if(isset($_SESSION['login'])==FALSE){
	print 'ログインされていません。<br />';
	print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
	exit();
} else {
	print $_SESSION['staff_name'];
	print 'さんログイン中<br />';
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
		$sql = 'SELECT code,name FROM mst_staffs WHERE 1';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		// データベースから切断
		$dbh = null;

		print 'スタッフ一覧 <br /><br />';

		print '<form method = "post" action ="staff_branch.php">';
		// $stmtから1レコードを取得
		while(true){
			$rec = $stmt->fetch(PDO::FETCH_ASSOC);
			if($rec == FALSE){
				break;
			}
			// スタッフを選んだ際に飛び先がわかるようにコードを渡しています。
			print '<input type = "radio" name = "staffcode" value = "'.$rec['code'].'">';
			print $rec['name'];
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
	<br />
	<a href = "../staff_login/staff_top.php">トップメニューへ</a>
</body>