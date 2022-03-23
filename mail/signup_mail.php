<?php
session_start();
// クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');
require('../library.php');

$error = [];

if($_SERVER['REQUEST_METHOD'] === "POST"){
    // --------------------  メールアドレスの空白エラーキャッチ ----------------------
    $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    // メールの欄が空欄の時
    if($form['email'] == ''){
        // エラー配列のemail要素にblankを格納
        $error['email'] = 'blank';
    // --------------------  メールアドレスのかぶりエラーキャッチ --------------------
    }else{
        // データベースに接続(../library.phpで宣言した関数)
        $db = dbconnect();
        // テーブルから全てのデータを抽出
        $stmt = $db->prepare('select count(*) from user where email=?');
        if(!$stmt){
            die($db->error);
        }
        $stmt->bind_param('s', $form['email']);
        $success = $stmt->execute();
        if(!$success){
            die($db->error);                
        }

        // 実行結果を$cntにバインド
        $stmt->bind_result($cnt);
        // 値を取得
        $stmt->fetch();
        // $cntが0より大きい = 同じメールアドレスが存在する時
        if($cnt > 0){
            // エラー配列のemail要素にduplicateを格納
            $error['email'] = 'duplicate';
        }
    }

    if(empty($error)){
        header('Location: thanks.php');
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>仮会員登録</title>
</head>
<body>
    <h1>仮会員登録画面</h1>
    <form action="" method="POST">
        <!-- ------------------- メールアドレス ------------------------ -->
        <input type="text" name="email" placeholder="メールアドレス"><br>
        <!-- エラーメッセージ(空白) -->
        <?php if(isset($error['email']) && $error['email'] === 'blank'): ?>
            <p>※メールアドレスを入力してください</p>
        <?php endif; ?>
        <!-- エラーメッセージ(メールの重複) -->
        <?php if(isset($error['email']) && $error['email'] === 'duplicate'): ?>
            <p>※指定したメールアドレスは既に登録されています</p>
        <?php endif; ?>
        <input type="submit" value="送信">
    </form>
</body>
</html>