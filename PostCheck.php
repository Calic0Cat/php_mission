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
	if(isset($_SESSION['login']==false)){
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
	
	require_once('DbFunction.php');
	$dbFunction = new DbFunction();

	//ファイルアップロードがあったとき
	if (isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error']) && $_FILES["upfile"]["name"] !== ""){
		//エラーチェック
		switch ($_FILES['upfile']['error']) {
			case UPLOAD_ERR_OK: // OK
				break;
			case UPLOAD_ERR_NO_FILE:   // 未選択
				throw new RuntimeException('ファイルが選択されていません', 400);
			case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
				throw new RuntimeException('ファイルサイズが大きすぎます', 400);
			default:
				throw new RuntimeException('その他のエラーが発生しました', 500);
		}

		//画像・動画をバイナリデータにする．
		$raw_data = file_get_contents($_FILES['upfile']['tmp_name']);

		//拡張子を見る
		$tmp = pathinfo($_FILES["upfile"]["name"]);
		$extension = $tmp["extension"];
		if($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG"){
			$extension = "jpeg";
		}
		elseif($extension === "png" || $extension === "PNG"){
			$extension = "png";
		}
		elseif($extension === "gif" || $extension === "GIF"){
			$extension = "gif";
		}
		elseif($extension === "mp4" || $extension === "MP4"){
			$extension = "mp4";
		}
		else{
			echo "非対応ファイルです．<br/>";
			echo ("<a href=\"index.php\">戻る</a><br/>");
			exit(1);
		}

		//DBに格納するファイルネーム設定
		//サーバー側の一時的なファイルネームと取得時刻を結合した文字列にsha256をかける．
		$date = getdate();

		//画像・動画をDBに格納．
		$sql = "INSERT INTO media(fname, extension, raw_data) VALUES (:fname, :extension, :raw_data);";

	}
?>

</body>
</html>
