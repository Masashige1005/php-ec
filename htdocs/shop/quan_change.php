<?php
	session_start();
	session_regenerate_id(true);

	require_once('../common/common.php');

	$post = sanitize($_POST);

	$max = $post['max'];
	for($i=0;$i<$max;$i++){
		if(preg_match("/¥A[0-9]+¥z/", $post['quan'.$i]) == 0){
			print '数量に誤りがあります。';
			print '<a href="shop_cartlook.php">カートに戻る</a>';
			exit();
		}
		$quan[] = $post['quan'.$i];
	}

	$cart = $_SESSION['cart'];
	// 普通のループでは大きい数は結果がずれてしまうので逆順ループを使用
	for($i=$max;0<=$i;$i--){
		if(isset($_POST['delete'.$i])==TRUE){
			// 配列の要素を削除する
			array_splice($cart, $i,1);
			array_splice($quan, $i,1);
		}
	}
	$_SESSION['cart'] = $cart;
	$_SESSION['quan'] = $quan;

	header('Location: shop_cartlook.php');
	exit();
?>