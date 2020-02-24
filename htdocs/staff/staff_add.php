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
	スタッフ追加<br/>
	<br />
	<form method = "post" action = "staff_add_check.php">
		スタッフ名を入力してください。<br />
		<input type = "text" name= "name" style = "width:200px"><br />
		パスワードを入力してください。<br />
		<input type = "password" name = "pass" style = "width:100px"><br />
		パスワードをもう一度入力してください。<br />
		<input type = "password" name = "pass2" style = "width:100px"><br />
		<br />
		<input type = "button" onclick = "histrory.back()" value = "戻る">
		<input type = "submit" value = "OK">
	</form>

</body>
</html>
