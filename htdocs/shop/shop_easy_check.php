<?php
session_start();
// 現在のセッションIDを 新しいものと置き換える。その際、現在のセッション情報は維持
session_regenerate_id(true);
if(isset($_SESSION['login'])==FALSE){
	print 'ログインされていません。<br />';
	print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
	exit();
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
	$code = $_SESSION['member_code'];

	$dsn = 'mysql:dbname=app-db;host=localhost;charset=utf8';
	$user = 'root';
	$password = '';
	$dbh = new PDO($dsn,$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	$sql = 'SELECT name,email,postal1,postal2,address,tel FROM dat_member WHERE code=?';
	$stmt = $dbh->prepare($sql);
	$data[] = $code;
	$stmt->execute($data);
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);

	$dbh =null;

	$name = $rec['name'];
	$email = $rec['email'];
	$postal1 = $rec['postal1'];
	$postal2 = $rec['postal2'];
	$address = $rec['address'];
	$tel = $rec['tel'];

	print 'お名前<br />';
	print $name;
	print '<br /><br />';

	print 'メールアドレス<br />';
	print $email;
	print '<br /><br />';

	print '郵便番号<br />';
	print $postal1;
	print '-';
	print $postal2;
	print '<br /><br />';

	print '住所<br />';
	print $address;
	print '<br /><br />';

	print '電話番号<br />';
	print $tel;
	print '<br /><br />';

	print '<form method = "post" action = "shop_form_done.php">';
	print '<input type = "hidden" name = "name" value = "'.$name.'">';
	print '<input type = "hidden" name = "email" value = "'.$email.'">';
	print '<input type = "hidden" name = "postal1" value = "'.$postal1.'">';
	print '<input type = "hidden" name = "postal2" value = "'.$postal2.'">';
	print '<input type = "hidden" name = "address" value = "'.$address.'">';
	print '<input type = "hidden" name = "tel" value = "'.$tel.'">';
	print '<input type = "submit" value = "OK"><br />';
	print '</form>';