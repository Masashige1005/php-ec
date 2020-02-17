<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title></title>
</head>
<body>
	<?php
	// 変数の中身を確認後それぞれのページへ移行
	if(isset($_POST['edit']) == TRUE){
		$staff_code = $_POST['staffcode'];
		// 移行する際にURLパラメータでスタッフコードを渡す
		header('Location:staff_edit.php?staffcode='.$staff_code);
		exit();
	}
	if(isset($_POST['delete']) == TRUE){
		$staff_code = $_POST['staffcode'];
		header('Location:staff_delete.php?staffcode='.$staff_code);
		exit();
	}
	?>
</body>