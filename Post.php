<!DOCTYPE html>
<html lang="ja">
<html>
<head>
<meta charset="utf-8">
<title>動物ブログ</title>
</head>

<?php 
    require_once('DbFunction.php');
    $dbFunction = new DbFunction();
    // $sql = 'CREATE TABLE IF NOT EXISTS  interim_registration(number int(11)  AUTO_INCREMENT PRIMARY KEY,regName varchar(20),regId varchar(20),regPass varchar(32))';
	$sql = 'CREATE TABLE IF NOT EXISTS  blog_id_2(number int(11)  AUTO_INCREMENT PRIMARY KEY,
		id varchar(20) NOT NULL,
    	name varchar(20) NOT NULL,
    	password varchar(32) NOT NULL)';
	$dbFunction->createTable($sql);

?>
<body>
<form method="post" action="MainPage.php"enctype="multipart/form-data">
	<fieldset>
	<legend>動物ブログ</legend>
	<pre>名前     :  <input type="text" name="name" style="width:100px" value="<?php echo $name; ?>"></br></pre>
	<pre>コメント :  <input type="text" name="comment" style="width:100px" value="<?php echo $editComment; ?>"></br></pre>
	<pre>ファイル   :  <input type="file" name="upfile" ></br></pre>
	<pre>パスワード   :  <input type="password" name="password" style="width:100px"></br></pre>
	<input type="hidden" name="editEnd" value="<?php echo $editNum; ?>">
	<input type="submit" value='送信'> 
	</fieldset>
</form>
</body>
</html>
