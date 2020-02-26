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
	$post = sanitize($_POST);
	$staff_code = $post['code'];
	$staff_name = $post['name'];
	$staff_pass = $post['pass'];
	$staff_pass2 = $post['pass2'];

	require_once('../common/common.php')

	if($staff_name == ''){
		print 'スタッフの名前が入力されていません。<br />';
	} else {
		print 'スタッフ名:';
		print $staff_name;
		print '<br />';
	}

	if($staff_pass == ''){
		print 'パスワードが入力されていません。<br />';
	}

	if($staff_pass != $staff_pass2){
		print 'パスワードが一致しません <br />';
	}

	if($staff_name == '' || $staff_pass == '' || $staff_pass != $staff_pass2){
		print '<form>';
		print '<input type = "button" onclick = "history.back()" value = "戻る">';
		print '<form>';
	} else {
		// 暗号化
		$staff_pass = md5($staff_pass);
		print '<form method = "post" action = "staff_edit_done.php">';
		print '<input type = "hidden" name = "code" value = "'.$staff_code.'">';
		print '<input type = "hidden" name = "name" value = "'.$staff_name.'">';
		print '<input type = "hidden" name = "pass" value = "'.$staff_pass.'">';
		print '<br />';
		print '<input type = "button" onclick = "history.back()" value = "戻る">';
		print '<input type = "submit" value = "OK">';
		print '</form>';
	}
	?>

</body>
</html>
