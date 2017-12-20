<!DOCTYPE html>
<html lang="ja">
<html>
<head>
<meta charset="utf-8">
<title>動物ブログ</title>
</head>

<body>
<?php
	session_start();
	session_regenerate_id(true);
	if(isset($_SESSION['login']) == false){
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
    //phpinfo();
    //サニタイジング
    require_once('Common.php');
    $post=sanitize($_POST);

    //post受け取り
    $name = $_SESSION['name'];
    $comment = $post['comment'];
    $password = $post['password'];
    $editName = $post['editName'];
    $editComment = $post['editComment'];
    $editEnd = $post['editEnd'];
    $delNum = $post['delNum'];
    $editNum = $post['editNum'];
    
    
    $time = date( "Y/m/d H:i:s" ,time());

    require_once('DbFunction.php');
    $dbFunction = new DbFunction();
    //ブログの中身生成テーブル
    //$sql = 'CREATE TABLE IF NOT EXISTS  interim_registration(number int(11)  AUTO_INCREMENT PRIMARY KEY,name varchar(20),comment text NOT NULL,time TIMESTAMP,rawData longblob,extension varchar(5),password varchar(32))';
    //idテーブル
    // $sql = 'CREATE TABLE IF NOT EXISTS  blog_id(id varchar(20) PRIMARY KEY,
    // name varchar(20),
    // password varchar(32))';
    //$dbFunction->createTable($sql);
    include ('Post.php');
    include ('PostDelete.php');
    include ('PostEdit.php');

    //通常入力
    if (isset($name,$comment) && empty($editEnd)){
        if(isset($_FILES)){
            $rawData = file_get_contents($_FILES['upfile']['tmp_name']);            
            $tmp = pathinfo($_FILES["upfile"]["name"]);
            $extension = fileCheck($tmp["extension"]);
        }
        $sql = 'INSERT INTO blog_index (name,comment,time,rawData,extension,password) VALUES (?,?,?,?,?,?)';  
        $data = array($name,$comment,$time,$rawData,$extension,$password);
        $dbFunction->sql($sql,$data);
    }
    //編集の時
    else if(isset($editEnd)){
        $sql = 'UPDATE blog_index SET name=?,comment=?,time=? WHERE number=?';
        $data = array(" [編集]  ".$name,$comment,$time,$editEnd);      
        $dbFunction->sql($sql,$data);      
    }
    //削除の時
    else {
        $sql = 'DELETE FROM blog_index WHERE number=?';
        $data[] = $delNum;        
        $dbFunction->sql($sql,$data);
    }
    $sql = 'SELECT * FROM blog_index';    
    $dbFunction->displayData($sql);
?>
</body>
</html>
