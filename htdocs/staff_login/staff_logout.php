
<?php
session_start();
// セッション変数を空にする
$_SESSION = array();
if(isset($_COOKIE[session_name()]) == TRUE){
	// セッションIDをクッキーから削除、setcookie前に画面表示があるといけない。
	setcookie(session_name(),'',time()-42000,'/');
}
// セッションを破棄
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title></title>
<body>
	ログアウトしました<br />
	<a href = "../staff_login/staff_login.html">ログイン画面へ</a>
</body>