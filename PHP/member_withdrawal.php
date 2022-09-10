<?php

// エラー表示
ini_set('display_errors', 1);

require_once("./function.php");

session_start();
//session_unset();

// ログインしていない場合トップページに戻る
if (empty($_SESSION["member"])) {
    // このファイルをブラウザに返す
    header('Location: top.php');
}

if (!empty($_POST['btn_submit'])) {
    if(memberWithdrawal($_SESSION["member"]["id"])){
        unset($_SESSION['member']);
        header('Location: top.php');
        exit;
    }
}

//var_dump($_SESSION);
// echo $_SESSION["member"]["id"];
?>

<!DOCTYPE>
<html>

<head>
    <title>退会ページ</title>
    <link rel="stylesheet" href="./CSS/form.css">
</head>

<body>
    <div class="header">
        <div class="right_column">
            <input class="button" type="button" onclick="location.href='./top.php'" value="トップに戻る">
        </div>
    </div>
    <div class="box">
        <h1>退会</h1>
        <p>退会しますか？</p>
        <form action="" method="post">
            <input class="btn_blue" type="submit" name="btn_submit" value="退会する">
        </form>
    </div>
</body>

</html>