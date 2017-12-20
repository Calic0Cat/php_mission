<?php
//サニタイジングを一括化
//$beforeで一気に受け取って$afterに一括代入
function sanitize($before){
    foreach($before as $key => $value){
        $after[$key] = htmlspecialchars($value,ENT_QUOTES,'UTF-8');
    }
    return $after;
}

function loginCheck(){
    session_start();
    $_SESSION['login'] = 1;
    $_SESSION['id'] = $id;
    $_SESSION['name'] = $userName;
}

function fileCheck($extension){
    //画像・動画をバイナリデータにする．

    //拡張子を見る
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
        exit();
    }
    return $extension;
}



?>