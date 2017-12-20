<!DOCTYPE html>
<html lang="ja">
<html>
<head>
<meta charset="utf-8">
<title>動物ブログ</title>
</head>

<body>
<?php
echo $_POST['mailAdr']."宛に確認メールを送信しました。";
?>

<?php 

$regName = $_POST['regName'];
$regId = $_POST['regId'];
$regPass = $_POST['regPass'];
$mailAdr = $_POST['mailAdr'];
require_once('DbFunction.php');
$dbFunction = new DbFunction();


$sql = 'INSERT INTO interim_registration (regName,regId,regPass) VALUES (?,?,?)';
$data = array($regName,$regId,$regPass);             

$dbFunction->sql($sql,$data);

$subject = 'e-mail confirm';
$message = "http://co-1002.it.99sv-coco.com/BBS/Confirm.php?regName=$regName&regId=$regId";
$headers = 'From: suzuki11235813@gmail.com';

mail($mailAdr, $subject, $message, $headers);


?>
</body>
</html>
