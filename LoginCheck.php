<?php 
    require_once('DbFunction.php');
	$dbFunction = new DbFunction();
	require_once('Common.php');
	$post=sanitize($_POST);

	$name = $post['name'];	
	$id = $post['id'];
	$password = $post['password'];
	if(!isset($name,$id,$password)){
		echo '正しく入力してください。</br></br>';
		print'<input type="button" onclick="history.back()" value="戻る">';
		exit;
	}
	require_once('DbFunction.php');
	$dbFunction = new DbFunction();
	$sql = 'SELECT * FROM blog_id_2';
	$data = array($id,$password);             
	
	$return = $dbFunction->sql($sql,$data);
	session_start();
	$_SESSION['login'] = 1;
	$_SESSION['name'] = $return[1];
		
	header('Location:MainPage.php');
	exit();




?>
