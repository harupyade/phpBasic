<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo ini_set('display_errors', 1);

// 関数取得
require_once("./function.php");

// 新しいセッションを開始
// リクエスト上で GET, POST またはクッキーにより渡された
// セッション ID に基づき現在のセッションを復帰
session_start();

// セッション使用時にブラウザキャッシュを有効にする
// 下3行がないと、前に戻るボタンでエラーがが発生する
header('Expires: -1');
header('Cache-Control:');
header('Pragma:');

// 会員情報取得
$member_data = memberInfo($_POST['email']);

if(!empty($_POST["btn_confirm"])){

    // エラーの初期値
    $errors = array();

    // メールアドレスのバリデーション
    if( empty($_POST['email'])){
        $errors['email'] = "※メールアドレスは必須入力です。";
    }elseif(!emailExists($_POST['email'])) {
		$errors['email'] = "※メールアドレスが存在しません。";
	}

    // パスワードのバリデーション
    if( empty($_POST['password']) ) {
		$errors['password'] = "※パスワードは必須入力です";
	}elseif($member_data["password"] !== $_POST['password']){
        $errors['password'] = "※パスワードが一致しません。";
    }

    if(empty($errors)){
        // $_SESSIONに$_POSTで取得した情報追加(ログインした人の情報取得)
        $_SESSION["member"] = $member_data; 

        // このファイルをブラウザに返す
        header('Location: top.php'); 

        // 現在のスクリプト終了
        exit();
    }

}


?>


<!DOCTYPE>
<html>
    <head>
        <title>ログインフォーム</title>
        <link rel="stylesheet" href="./CSS/form.css">
    </head>
    <body>
    <div class="box">
        <h1>ログイン</h1>
        <form action="" method="post">
            <table>
                <!-- メールアドレス -->
                <tr>
                    <td>メールアドレス(ID)</td>
                    <td><input type="text" name="email" value="<?php if( !empty($_POST['email']) ){ echo $_POST['email']; } ?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="color:red">
                        <?php 
                            if(!empty($errors["email"])){
                                echo $errors['email'];
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>パスワード</td>
                    <td><input type="password" name="password" ></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="color:red">
                        <?php 
                            if(!empty($errors["password"])){
                                echo $errors['password'];
                            }
                        ?>
                    </td>
                </tr>
            </table>
            <input class="btn_blue" type="submit" name="btn_confirm" value="ログイン"  >
            <input class="btn_blue" type="button" onclick="location.href='./top.php'"value="トップに戻る">
        </form>
    </div>
    <!-- .boxここまで -->
    </body>
</html>