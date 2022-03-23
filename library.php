<?php
// HTMLを実体に変換する関数
function h($value){
    // htmlspecialchars(エスケープする文字列,エスケープの種類)
    return htmlspecialchars($value,ENT_QUOTES);
}

// DB接続設定
function dbconnect(){
    $db = new mysqli('localhost', 'root', 'root', 'test_db');
    if(!$db){
        die($db->error);
    }
    // $sql = 'create table IF NOT EXISTS members (
    //     id INT AUTO_INCREMENT PRIMARY KEY,
    //     name char(32),
    //     email varchar(128),
    //     password TEXT
    // )';
    // // 宣言したデータベースで$sqlを実行
    // $db->query($sql);
    return $db;
}
?>



