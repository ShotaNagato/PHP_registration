<!-- 登録情報確認画面
確認メール送信
 -->
 <?php
 session_start();
 require('../library.php');
//  セッションが送られてきた時
 if(isset($_SESSION['form'])){
     $form = $_SESSION['form'];
 }else{
     // セッションがない状態でページに遷移した時index.phpに移動
     header('Location: signup.php');
     exit();
 }
//  $form = $_SESSION['form'];
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録内容確認</title>
</head>
<body>
    <h1>登録内容確認画面</h1>
    <p>記入した内容を確認して「登録する」ボタンを押してください</p>
    <form action="" method="post">
        <dl>
            <dt>名前</dt>
            <dd><?php echo h($form['name']); ?></dd>
            <dt>メールアドレス</dt>
            <dd><?php echo h($form['email']); ?></dd>
            <dt>パスワード</dt>
            <dd>【表示されません】</dd>
        </dl>
        <input type="submit" value="登録する">
        <a href="signup.php?action=rewrite">書き直す</a>
    </form>
</body>
</html>