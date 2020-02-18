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
		// 選択されない時の処理
		if(isset($_POST['staffcode']) == FALSE){
			header('Location:staff_ng.php');
			exit();
		}
		$staff_code = $_POST['staffcode'];
		// 移行する際にURLパラメータでスタッフコードを渡す
		header('Location:staff_edit.php?staffcode='.$staff_code);
		exit();
	}
	if(isset($_POST['delete']) == TRUE){
		if(isset($_POST['staffcode']) == FALSE){
			header('Location:staff_ng.php');
			exit();
		}
		$staff_code = $_POST['staffcode'];
		header('Location:staff_delete.php?staffcode='.$staff_code);
		exit();
	}
	if(isset($_POST['add']) == TRUE){
		header('Location:staff_add.php');
		exit();
	}
	?>
</body>