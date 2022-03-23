<!-- ユーザー登録画面 -->
<?php
    /**
     * 入力フォーム
     * ・名前
     * ・メール
     * ・パスワード
     * データベース作成
     * エラーチェック
     * ・名前空
     * ・メール空
     * ・パス空
     */
    session_start();
    require('../library.php');

    // 確認画面から遷移してきた時(action=rewrite)
    if(isset($_GET['action']) && $_GET['action'] === 'rewrite' && isset($_SESSION['form'])){
        $form = $_SESSION['form'];
    }else{
        // 新規画面の時は初期化
        $form = [
            'name' => '',
            // 'email' => '',
            'password' => ''
        ];
    }
    $error = [];

    // 確認フォームが送信された時
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        // --------------------  名前の空白エラーキャッチ ------------------------------
        $form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        // 名前の欄が空欄の時
        if($form['name'] == ''){
            // エラー配列のname要素にblankを格納
            $error['name'] = 'blank';
        }

        // // --------------------  メールアドレスの空白エラーキャッチ ----------------------
        // $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        // // メールの欄が空欄の時
        // if($form['email'] == ''){
        //     // エラー配列のemail要素にblankを格納
        //     $error['email'] = 'blank';
        // // --------------------  メールアドレスのかぶりエラーキャッチ --------------------
        // }else{
        //     // データベースに接続(../library.phpで宣言した関数)
        //     $db = dbconnect();
        //     // テーブルから全てのデータを抽出
        //     $stmt = $db->prepare('select count(*) from members where email=?');
        //     if(!$stmt){
        //         die($db->error);
        //     }
        //     $stmt->bind_param('s', $form['email']);
        //     $success = $stmt->execute();
        //     if(!$success){
        //         die($db->error);                
        //     }

        //     // 実行結果を$cntにバインド
        //     $stmt->bind_result($cnt);
        //     // 値を取得
        //     $stmt->fetch();
        //     // $cntが0より大きい = 同じメールアドレスが存在する時
        //     if($cnt > 0){
        //         // エラー配列のemail要素にduplicateを格納
        //         $error['email'] = 'duplicate';
        //     }
        // }

        // --------------------  パスワードの空白、文字数エラーキャッチ -------------------------
        $form['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        // passwordの欄が空欄の時
        if($form['password'] == ''){
            // エラー配列のpassword要素にblankを格納
            $error['password'] = 'blank';
        // 文字数が4より少ない時
        }elseif(strlen($form['password']) < 4){
            // エラー配列のpassword要素にlengthを格納
            $error['password'] = 'length';
        }

        // エラーが一つも出なければ
        if(empty($error)){
            // 入力された値を格納した連想配列$formを$_SESSION['form]に格納
            $_SESSION['form'] = $form;
            // check.phpに遷移する
            header('Location: check.php');
            // 処理を終了する
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
    <title>ユーザー登録</title>
</head>
<body>
    <h1>会員登録画面</h1>
    <!-- ------------------------------- 入力フォーム ------------------------------- -->
    <form action="" method="POST">
        <!-- ------------------- 名前 -------------------------------- -->
        <input type="text" name="name" placeholder="名前" value="<?php echo h($form['name']); ?>"><br>
        <!-- エラーメッセージ(空白) -->
        <?php if(isset($error['name']) && $error['name'] === 'blank'): ?>
            <p>※名前を入力してください</p>
        <?php endif; ?>

        <!-- ------------------- パスワード --------------------------- -->
        <input type="password" name="password" placeholder="パスワード" value="<?php echo h($form['password']); ?>"><br>
        <!-- エラーメッセージ(空白) -->
        <?php if(isset($error['password']) && $error['password'] === 'blank'): ?>
            <p>※パスワードを入力してください</p>
        <?php endif; ?>
        <!-- エラーメッセージ(文字数) -->
        <?php if(isset($error['password']) && $error['password'] === 'length'): ?>
            <p>※パスワードは4文字以上で入力してください</p>
        <?php endif; ?>

        <input type="submit" value="入力内容を確認">
    </form>
</body>
</html>