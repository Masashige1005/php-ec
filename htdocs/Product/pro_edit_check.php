<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title></title>
</head>
<body>
	<?php
	$pro_code = $_POST['code'];
	$pro_name = $_POST['name'];
	$pro_price = $_POST['price'];

	// 入力情報の安全対策
	$pro_code = htmlspecialchars($pro_code,ENT_QUOTES,'UTF-8');
	$pro_name = htmlspecialchars($pro_name,ENT_QUOTES,'UTF-8');
	$pro_price = htmlspecialchars($pro_price,ENT_QUOTES,'UTF-8');

	if($pro_name == ''){
		print '商品名が入力されていません。<br />';
	} else {
		print '商品名:';
		print $pro_name;
		print '<br />';
	}

	if($pro_price == ''){
		print '価格が入力されていません。<br />';
	} else {
		print '価格:';
		print $pro_price;
		print '円<br />';
	}
	if($pro_name == '' || $pro_price == ''){
		print '<form>';
		print '<input type = "button" onclick = "history.back()" value = "戻る">';
		print '<form>';
	} else {
		print '上記のように変更します。';
		print '<form method = "post" action = "pro_edit_done.php">';
		print '<input type = "hidden" name = "code" value = "'.$pro_code.'">';
		print '<input type = "hidden" name = "name" value = "'.$pro_name.'">';
		print '<input type = "hidden" name = "price" value = "'.$pro_price.'">';
		print '<br />';
		print '<input type = "button" onclick = "history.back()" value = "戻る">';
		print '<input type = "submit" value = "OK">';
		print '</form>';
	}
	?>

</body>
</html>
