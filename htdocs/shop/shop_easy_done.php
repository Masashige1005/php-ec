<?php
session_start();
session_regenerate_id(true);

if(isset($_SESSION['member_login'])==false){
	print 'ログインされていません。<br />';
	print '<a href="shop_list.php">商品一覧へ</a><br />';
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
	try{
		require_once('../common/common.php');
		$post = sanitize($_POST);

		$name = $post['name'];
		$email = $post['email'];
		$postal1 = $post['postal1'];
		$postal2 = $post['postal2'];
		$address = $post['address'];
		$tel = $post['tel'];
		$order = $post['order'];
		$pass = $post['pass'];
		$sex = $post['sex'];
		$birth = $post['birth'];

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
			$cost[] = $pro_price;
			$stock = $quan[$i];
			$sub_price = $pro_price * $stock;

			$text.= $name.' ';
			$text.= $pro_price.'円 x';
			$text.= $stock.'個 = ';
			$text.= $sub_price."円 \n";
		}

		$sql = 'LOCK TABLES dat_sales WRITE,dat_sales_product WRITE';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();

		$lastmembercode = $_SESSION['member_code'];
		if($order == 'order_join'){
			$sql = 'INSERT INTO dat_member(password,name,email,postal1,postal2,address,tel,sex,born) VALUES(?,?,?,?,?,?,?,?,?)';
			$stmt = $dbh->prepare($sql);
			$data = array();
			$data[] = md5($pass);
			$data[] = $name;
			$data[] = $email;
			$data[] = $postal1;
			$data[] = $postal2;
			$data[] = $address;
			$data[] = $tel;
			if($sex = 'men'){
				$data[] = 1;
			} else {
				$data[] = 2;
			}
			$data[] = $birth;
			$stmt->execute($data);

			$sql = 'SELECT LAST_INSERT_ID()';
			$stmt = $dbh->prepare($sql);
			$stmt->execute();
			$rec = $stmt->fetch(PDO::FETCH_ASSOC);
			$lastmembercode = $rec['LAST_INSERT_ID()'];
		}

		$sql = 'INSERT INTO dat_sales(code_member,name,email,postal1,postal2,address,tel) VALUES(?,?,?,?,?,?,?)';
		$stmt = $dbh->prepare($sql);
		$data = array();
		$data[] = $lastmembercode;
		$data[] = $name;
		$data[] = $email;
		$data[] = $postal1;
		$data[] = $postal2;
		$data[] = $address;
		$data[] = $tel;
		$stmt->execute($data);

		// オートインクリメントで発番された番号を取得
		$sql = 'SELECT LAST_INSERT_ID()';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		$lastcode = $rec['LAST_INSERT_ID()'];

		for($i=0;$i<$max;$i++){
			$sql = 'INSERT INTO dat_sales_product(code_sales,code_product,price,quantity) VALUES(?,?,?,?)';
			$stmt = $dbh->prepare($sql);
			$data = array();
			$data[] = $lastcode;
			$data[] = $cart[$i];
			$data[] = $cost[$i];
			$data[] = $quan[$i];
			// ★
			$stmt->execute($data);
		}

		$sql = 'UNLOCK TABLES';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();

		$dnh = null;

		if($order == 'order_join'){
			print '会員登録が完了しました。<br />';
			print '次回からメールアドレスとパスワードでログインしてください。<br />';
			print 'ご注文が簡単にできるようになります。';
			print '<br />';
		}

		$text.="送料は無料です。\n";
		$text.="----------------\n";
		$text.="\n";
		$text.="代金は以下の口座にお振込ください。\n";
		$text.="〇〇銀行 ⬜︎⬜︎支店　普通口座　123456\n";
		$text.="入金が確認され次第、梱包、発送させていただきます。\n";
		$text.="\n";

		if($order == 'order_join'){
			$text.= "会員登録が完了いたしました。\n";
			$text.= "次回からメールアドレスとパスワードをでログインしてください。 \n";
			$text.= "ご注文が簡単にできるようになります。 \n";
			$text.= "\n";
		}
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

	<br />
	<a href = "shop_list.php">商品画面</a>
</body>
</html>