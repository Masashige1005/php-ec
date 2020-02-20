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
		if(isset($_POST['procode']) == FALSE){
			header('Location:pro_ng.php');
			exit();
		}
		$procode = $_POST['procode'];
		// 移行する際にURLパラメータでスタッフコードを渡す
		header('Location:pro_edit.php?procode='.$procode);
		exit();
	}
	if(isset($_POST['delete']) == TRUE){
		if(isset($_POST['procode']) == FALSE){
			header('Location:pro_ng.php');
			exit();
		}
		$procode = $_POST['procode'];
		header('Location:pro_delete.php?procode='.$procode);
		exit();
	}
	if(isset($_POST['add']) == TRUE){
		header('Location:pro_add.php');
		exit();
	}
	if(isset($_POST['disp']) == TRUE){
		if(isset($_POST['procode']) == FALSE){
			header('Location:pro_ng.php');
			exit();
		}
		$procode = $_POST['procode'];
		header('Location:pro_disp.php?procode='.$procode);
		exit();
	}
	?>
</body>