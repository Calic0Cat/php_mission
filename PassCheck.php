<!DOCTYPE html>
<html lang="ja">
<html>
<head>
<meta charset="utf-8">
<title>猫ブログ</title>
</head>

<body>
<?php
	session_start();
	session_regenerate_id(true);
	if(isset($_SESSION['login'])==false){
		print'ログインされていません</br>';
		print'<a href="Login.php">ログイン画面へ</a>';
		exit();
	}
	else{
		print$_SESSION['name'];
		print'さんログイン中</br></br>';
	}
?>
<?php
//受け取るべきデータを受け取る
	require_once('Common.php');
	$post=sanitize($_POST);
	$name = $post['name'];	
	$comment = $post['comment'];
	$password = $post['password'];
	$editNum = $post['editNum'];
	$delNum = $post['delNum'];
	if(empty($password)){
		echo 'パスワードを入力してください。</br></br>';
		print'<input type="button" onclick="history.back()" value="戻る">';
		exit;
	}
	$miss = FALSE;
	
	require_once('DbFunction.php');
	$dbFunction = new DbFunction();
	$sql = 'SELECT * FROM blog_index';
	if(isset($delNum)){
		$data = $dbFunction->referenceData($sql,$delNum);
	}else{
		$data = $dbFunction->referenceData($sql,$editNum);
	}
	//データ削除
	if($delNum == $data[0] && $password == $data[3]){
		$miss = TRUE;
		echo "番号　：".$delNum."　の投稿を本当に削除しますか？</br></br>";

		print'<form method="post" action="MainPage.php">';
		print'<input type="hidden" name="delNum" value="'.$delNum.'">';
		print'<input type="button" onclick="history.back()" value="戻る">';
		print'<input type="submit" value="OK">';
		print'</form>';
	
	}
	//データ編集
	else if($editNum == $data[0] && $password == $data[3]){
		$miss = TRUE;
		echo "名前　： ".$data[1]."  コメント　： ".$data[2];
		echo '</br>を本当に編集しますか？</br></br>';

		print'<form method="post" action="MainPage.php">';
		print'<input type="hidden" name="editComment" value="'.$data[2].'">';
		print'<input type="hidden" name="editNum" value="'.$editNum.'"';
		print'<input type="button" onclick="history.back()" value="戻る">';
		print'<input type="submit" value="OK">';
		print'</form>';
	}
	//パスワードが違うとき
	if($miss == FALSE){
		echo '正しいパスワードを入力してください。</br></br>';
		print'<input type="button" onclick="history.back()" value="戻る">';
	}

?>
</body>
</html>
