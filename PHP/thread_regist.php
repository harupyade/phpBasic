<?php
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

// エラー表示
ini_set('display_errors', 1);

// ログアウト時はtopに返す
if (empty($_SESSION["member"])) {
    header('Location: top.php');
} elseif (empty($_SESSION["member"]["id"])) {
    // 会員情報取得
    $_SESSION["member"]["id"] = memberInfo($_SESSION['member']['email'])["id"];
}

if (!empty($_POST["btn_confirm"])) {

    // エラーの初期値
    $errors = array();

    // スレッドタイトルのバリデーション
    if (empty($_POST['title'])) {
        $errors['title'] = "※スレッドタイトルは必須入力です。";
    } elseif (100 < mb_strlen($_POST['title'])) {
        $errors['title'] = "※スレッドタイトルは100文字以内で入力してください。";
    }

    // コメントのバリデーション
    if (empty($_POST['content'])) {
        $errors['content'] = "※コメントは必須入力です。";
    } elseif (500 < mb_strlen($_POST['content'])) {
        $errors['content'] = "※コメントは500文字以内で入力してください。";
    }

    if (empty($errors)) {
        // $_SESSIONに$_POSTで取得した情報追加
        $_SESSION["thread"] = $_POST;

        // このファイルをブラウザに返す
        header('Location: thread_regist_confirm.php');

        // 現在のスクリプト終了
        exit();
    }
}

// $_SESSIONの中身を確認
var_dump($_SESSION);
//var_dump($errors);


?>

<!DOCTYPE>
<html>

<head>
    <title>スレッド作成フォーム</title>
    <link rel="stylesheet" href="./CSS/form.css">
</head>

<body>
    <div class="box">
        <h1>スレッド作成フォーム</h1>
        <form action="" method="post">
            <table>
                <!-- スレッドタイトル -->
                <tr>
                    <td>スレッドタイトル</td>
                    <td><input type="text" name="title" value="<?php if (!empty($_POST['title'])) {
                                                                    echo $_POST['title'];
                                                                } ?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="color:red">
                        <?php
                        if (!empty($errors["title"])) {
                            echo $errors['title'];
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>コメント</td>
                    <td><textarea name="content"><?php if (!empty($_POST['content'])) {
                                                        echo $_POST['content'];
                                                    } ?></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="color:red">
                        <?php
                        if (!empty($errors["content"])) {
                            echo $errors['content'];
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <input class="btn_blue" type="submit" name="btn_confirm" value="確認画面へ">
            <input class="btn_blue" type="button" onclick="location.href='./top.php'" value="トップに戻る">
        </form>
    </div>
</body>

</html>