<?php
class DbFunction {
    //定数
    const DB_NAME = '';
    const HOST = 'localhost';
    const USER = '';
    const CHARACTER_CODE = 'utf-8';
    const DB_PASS = '';

    // データベースサーバへの接続
    public function dbConnect(){ 
        $dsn="mysql:dbname=".self::DB_NAME.";host=".self::HOST.";charset=".self::CHARACTER_CODE;
        $user= self::USER;
        $dbpass= self::DB_PASS;
        try{
            $pdo = new PDO($dsn, $user, $dbpass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        catch(Exception $e){
            print('エラーが発生しました。:'.$e->getMessage());
            exit();
        }
        return $pdo;
    }

    //テーブル作成
    public function createTable($sql){
        $pdo = $this->dbConnect();
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        $pdo = null;
    }
    //データ処理
    public function sql($sql,$data){
        $pdo = $this->dbConnect();
        $stmt=$pdo->prepare($sql);
        $stmt->execute($data);
        $pdo = null;
        return $stmt;
    }
    //データ表示
    public function displayData($sql){
        $pdo = $this->dbConnect();
        $stmt=$pdo->query($sql);
        foreach ($stmt as $row) {
            // データベースのフィールド名で出力
            $target = $row['number'];
            $extension = $row['extension'];
            echo $row['number'].' '.$row['name'].' '.$row['comment'].' '.$row['time'];
            // 改行,extension = $extension
            echo '<br>';
            if($row["extension"] == "mp4"){
                echo ("<video src=\"importMedia.php?target=$target\" width=\"426\" height=\"240\" controls></video>");
                echo ("<br/><br/>"); 
                
            }
            elseif($row["extension"] == "jpeg" || $row["extension"] == "png" || $row["extension"] == "gif"){
                echo ("<img src='importMedia.php?target=$target'>");
                echo ("<br/><br/>"); 
                
            }
        }
        $pdo = null;
    }

    //データ取得
    public function referenceData($sql,$num){
        $pdo = $this->dbConnect();
		$stmt=$pdo->query($sql);
		// foreach文で配列の中身を一行ずつ出力
		foreach ($stmt as $row) {
            //一致した行の中身を返す
			if ($row['number'] == $num){
                $pdo = null;
                return array($row['number'], $row['name'], $row['comment'], $row['password']);
			}
		}
    }
    //id取得
    public function referenceid($sql,$data){
        $pdo = $this->dbConnect();
        $stmt=$pdo->query($sql);
        // foreach文で配列の中身を一行ずつ出力
        foreach ($stmt as $row) {
            //一致した行の中身を返す
            if ($row['id'] == $data[0] || $row['password'] == $data[1]){
                $pdo = null;
                return array($row['id'], $row['name'],$row['password']);
            }
            header('Location:Login.php?false=0');
        }
    }
    public function referenceRegister($sql,$data){
        $pdo = $this->dbConnect();
        $stmt=$pdo->query($sql);
        // foreach文で配列の中身を一行ずつ出力
        foreach ($stmt as $row) {
            //一致した行の中身を返す
            if ($row['regId'] == $data[0] && $row['regName'] == $data[1]){
                $pdo = null;
                return array($row['regId'], $row['regName'],$row['regPass']);
            }
        }
    }
    
}
?>