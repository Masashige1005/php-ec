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
<body>
	ショップ管理トップ<br />
	<br />
	<a href = "../staff/staff_list.php">スタッフ管理</a><br />
	<br />
	<a href = "../product/pro_list.php">商品管理</a>
	<br />
	<a href = "staff_logout.php">ログアウト</a>
</body>
</head>
</html>