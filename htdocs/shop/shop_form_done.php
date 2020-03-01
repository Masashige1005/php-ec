<?php
session_start();
session_regenerate_id(true);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title></title>
</head>
<body>
	<?php
	try{
		require_once('../common/common.php');
		$post = sanitize($_POST);

		$name = $post['name'];
		$email = $post['email'];
		$postal1 = $post['postal1'];
		$postal2 = $post['postal2'];
		$address = $post['address'];
		$tel = $post['tel'];

		print $name.'様<br />';
		print 'ご注文ありがとうございました。<br />';
		print $email.'にメールを送りましたのでご確認ください。<br />';
		print '商品は以下の住所に発送させていただきます。<br />';
		print $postal1.'-'.$postal2.'<br />';
		print $address.'<br />';
		print $tel.'<br />';

		$text = '';
		$text.= $name."様¥n¥n この度はご注文ありがとうございました。\n";
		$text.= "\n";
		$text.= "ご注文商品\n";
		$text.= "-------------\n";

		$cart = $_SESSION['cart'];
		$quan = $_SESSION['quan'];
		$max = count($cart);

		$dsn = 'mysql:dbname=app-db;host=localhost;charset=utf8';
		$user = 'root';
		$password = '';
		$dbh = new PDO($dsn,$user,$password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		for($i=0;$i<$max;$i++){
			$sql = 'SELECT code,name,price,image FROM mst_products WHERE code=?';
			$stmt = $dbh->prepare($sql);
			$data[0] = $cart[$i];
			$stmt -> execute($data);

			$rec = $stmt ->fetch(PDO::FETCH_ASSOC);
			$pro_name = $rec['name'];
			$pro_price = $rec['price'];
			$stock = $quan[$i];
			$sub_price = $pro_price * $stock;

			$text.= $name.' ';
			$text.= $pro_price.'円 x';
			$text.= $stock.'個 = ';
			$text.= $sub_price."円 \n";
		}
		$dnh = null;

		$text.="送料は無料です。\n";
		$text.="----------------\n";
		$text.="\n";
		$text.="代金は以下の口座にお振込ください。\n";
		$text.="〇〇銀行 ⬜︎⬜︎支店　普通口座　123456\n";
		$text.="入金が確認され次第、梱包、発送させていただきます。\n";
		$text.="\n";
		$text.="⬜︎⬜︎⬜︎⬜︎⬜︎⬜︎⬜︎⬜︎⬜︎⬜︎⬜︎⬜︎⬜︎⬜︎\n";

		// print '<br />';
		// \nを<br />に変換する
		// print nl2br($text);

		$title = 'ご注文ありがとうございます。';
		// 送信元のメールアドレスの設定
		$header = 'From: info@php.co.jp';
		$text = html_entity_decode($text,ENT_QUOTES,'UTF-8');
		mb_language('Japanese');
		mb_internal_encoding('UTF-8');
		// メールを送信する命令
		mb_send_mail($email,$title,$text,$header);

		$title = 'お客様からご注文がありました。';
		$headrt = 'From: '.$email;
		$text = html_entity_decode($text,ENT_QUOTES,'UTF-8');
		mb_language('Japanese');
		mb_internal_encoding('UTF-8');
		mb_send_mail('info@php.co.jp', $title,$text, $header);

	}

	catch (Exception $e){
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>
</body>
</html>