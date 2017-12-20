<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>動物ブログ</title>
</head>

<body>
<?php 

    $regName = $_GET['regName'];
    $regId = $_GET['regId'];
    $data = array($regId,$regName);
    require_once('DbFunction.php');
    $dbFunction = new DbFunction();
    $sql = 'SELECT * FROM interim_registration'; 
    $interimdata = $dbFunction->referenceRegister($sql,$data);
    echo $regId;
    echo $interimdata[0];     
    if($regId != $interimdata[0])
    {
        echo "キーが一致しません。";
        print'<input type="button" onclick="history.back()" value="戻る">';

    }
    else
    {
        $sql = 'INSERT INTO blog_id_2 (id,name,password) VALUES (?,?,?)'; 
        $data = array($regId,$regName,$interimdata[2]);
        $dbFunction->sql($sql,$data);
        echo "登録完了しました。</br></br>";
        print'<a href="Login.php">ログインページへ</a>';
    }
?>
</body>
</html>
