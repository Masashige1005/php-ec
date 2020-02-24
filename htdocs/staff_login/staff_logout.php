<?php
session_start();
$_SESSION = array();
if(isset($_COOKIE[session_name()]) == TRUE){
	setcookie(session_name(),'',time()-42000,'/');
}
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