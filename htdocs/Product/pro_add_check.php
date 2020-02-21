<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title></title>
</head>
<body>
	<?php
	$pro_name = $_POST['name'];
	$pro_price = $_POST['price'];
	// 画像の場合は$_FILESを使う
	$pro_image = $_FILES['image'];

	// 入力情報の安全対策
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
		print '価格を入力してください。<br />';
	} else {
		print '価格:';
		print $pro_price;
		print '円<br />';
	}
	if($pro_image['size'] > 0){
		if($pro_image['size'] > 1000000){
			print '画像が大き過ぎます。';
		} else {
			// 画像を「image」フォルダに格納　tmp_name: アップロードされている画像の場所と名前
			move_uploaded_file($pro_image['tmp_name'],'./image/'.$pro_image['name']);
			// アップロードした画像を表示
			print '<img src = "./image/'.$pro_image['name'].'">';
		}
	}

	if($pro_name == '' || $pro_price == '' || $pro_image['size'] > 1000000){
		print '<form>';
		print '<input type = "button" onclick = "history.back()" value = "戻る">';
		print '<form>';
	} else {
		// 暗号化
		print '<form method = "post" action = "pro_add_done.php">';
		print '<input type = "hidden" name = "name" value = "'.$pro_name.'">';
		print '<input type = "hidden" name = "price" value = "'.$pro_price.'">';
		// 画像名($pro_image['name']を次の画面に渡す。
		print '<input type = "hidden" name = "image_name" value = "'.$pro_image['name'].'">';
		print '上記の商品を追加します。<br />';
		print '<br />';
		print '<input type = "button" onclick = "history.back()" value = "戻る">';
		print '<input type = "submit" value = "OK">';
		print '</form>';
	}
	?>

</body>
</html>
