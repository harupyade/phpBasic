<?php
echo ini_set('display_errors', 1);

session_start();

if (!empty($_POST["btn_confirm"])) {
    // エラーの初期値
    $errors = array();

    $login_id = $_POST["login_id"];

    // DB接続
    $dbh = new PDO('mysql:dbname=harupyade_test;host=mysql57.harupyade.sakura.ne.jp;charset=utf8', 'harupyade', 'ztrdx_aj4f8ret');
    // SQL
    $sql = "SELECT * FROM administers WHERE login_id = :login_id AND deleted_at IS NULL";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $login_data = $stmt->fetch(PDO::FETCH_ASSOC);

    // ログインIDのバリデーション
    if (empty($_POST['login_id'])) {
        $errors['login_id'] = "※ログインIDは必須入力です。";
    } elseif (!preg_match('/^[0-9a-z]/', $_POST['login_id'])) {
        $errors['login_id'] = "ログインIDは半角英数字で入力してください。";
    } elseif (10 < strlen($_POST['login_id'])) {
        $errors['login_id'] = "ログインIDは7文字以上10文字以内で入力してください。";
    } elseif (7 > strlen($_POST['login_id'])) {
        $errors['login_id'] = "ログインIDは7文字以上10文字以内で入力してください。";
    } elseif (empty($login_data)) {
        $errors['login_id'] = "※ログインIDが存在しません。";
    }

    // パスワードのバリデーション
    if (empty($_POST['password'])) {
        $errors['password'] = "※パスワードは必須入力です";
    } elseif (!preg_match('/^[0-9a-z]/', $_POST['password'])) {
        $errors['password'] = "パスワードは半角英数字で入力してください。";
    } elseif (20 < strlen($_POST['password'])) {
        $errors['password'] = "パスワードは8文字以上20文字以内で入力してください。";
    } elseif (8 > strlen($_POST['password'])) {
        $errors['password'] = "パスワードは8文字以上20文字以内で入力してください。";
    } elseif ($login_data["password"] !== $_POST['password']) {
        $errors['password'] = "※パスワードが一致しません。";
    }

    if (empty($errors)) {
        // $_SESSIONに$_POSTで取得した情報追加(ログインした人の情報取得)
        $_SESSION["administer"] = $login_data;

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
    <title>管理画面ログイン</title>
    <link rel="stylesheet" href="../CSS/form.css">
</head>

<body>
    <div class="admin_header">

    </div>
    <div class="box">
        <h1>管理画面</h1>
        <form action="" method="post">
            <table>
                <!-- ログインID -->
                <tr>
                    <td>ログインID</td>
                    <td><input type="text" name="login_id" value="<?php if (!empty($_POST['login_id'])) {
                                                                        echo $_POST['login_id'];
                                                                    } ?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="color:red">
                        <?php
                        if (!empty($errors["login_id"])) {
                            echo $errors['login_id'];
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>パスワード</td>
                    <td><input type="password" name="password"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="color:red">
                        <?php
                        if (!empty($errors["password"])) {
                            echo $errors['password'];
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <input class="btn_blue" type="submit" name="btn_confirm" value="ログイン">
        </form>
    </div>
    <div class="admin_header">

    </div>
</body>

</html>