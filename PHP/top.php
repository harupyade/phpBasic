<?php

session_start();
//session_unset();

// $_SESSIONの中身を確認
//var_dump($_SESSION);
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
//echo $_ENV["db_name"];
?>

<!DOCTYPE>
<html>

<head>
    <title>トップページ</title>
    <link rel="stylesheet" href="./CSS/form.css">
</head>

<body>
    <?php if (!empty($_SESSION['member']['email'])) : ?>
        <div class="header">
            <div class="left_column">
                <p>ようこそ <?php echo $_SESSION["member"]["name_sei"] . " " . $_SESSION["member"]["name_mei"] ?> 様</p>
            </div>
            <div class="right_column">
                <input class="button" type="button" onclick="location.href='./thread.php'" value="スレッド一覧">
                <input class="button" type="button" onclick="location.href='./thread_regist.php'" value="新規スレッド作成">
                <input class="button" type="button" onclick="location.href='./logout.php'" value="ログアウト">
            </div>
        </div>
        <div class="box">
            <p>
                <font size="7">PHP掲示板</font>
            </p>
        </div>
        <div class="footer">
            <div class="right_column">
                <input class="button" type="button" onclick="location.href='./member_withdrawal.php'" value="退会">
            </div>
        </div>
    <?php else : ?>
        <div class="header">
            <div class="right_column">
                <input class="button" type="button" onclick="location.href='./thread.php'" value="スレッド一覧">
                <input class="button" type="button" onclick="location.href='./member_regist.php'" value="新規会員登録">
                <input class="button" type="button" onclick="location.href='./login.php'" value="ログイン">
            </div>
        </div>
        <div class=box>

        </div>
    <?php endif ?>
</body>

</html>