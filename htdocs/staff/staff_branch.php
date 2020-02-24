<?php
session_start();
// 現在のセッションIDを 新しいものと置き換える。その際、現在のセッション情報は維持
session_regenerate_id(true);
if(isset($_SESSION['login'])==FALSE){
	print 'ログインされていません。<br />';
	print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
	exit();
}
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
if(isset($_POST['disp']) == TRUE){
	if(isset($_POST['staffcode']) == FALSE){
		header('Location:staff_ng.php');
		exit();
	}
	$staff_code = $_POST['staffcode'];
	header('Location:staff_disp.php?staffcode='.$staff_code);
	exit();
}
?>