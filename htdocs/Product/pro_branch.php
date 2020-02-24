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