<?php
    require_once('DbFunction.php');
    $dbFunction = new DbFunction();
    $target[] = $_GET["target"];
    $MIMETypes = array(
        'png' => 'image/png',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'mp4' => 'video/mp4'
    );
    try {
        $sql = 'SELECT * FROM blog_index WHERE number=?';
        $stmt = $dbFunction->sql($sql,$target);
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
        header("Content-Type: ".$MIMETypes[$row["extension"]]);
        echo ($row["rawData"]);
    }
    catch (PDOException $e) {
        echo("<p>500 Inertnal Server Error</p>");
        exit($e->getMessage());
    }
?>
