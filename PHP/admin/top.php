<?php
session_start();

//var_dump($_SESSION);
?>

<!DOCTYPE>
<html>

<head>
    <title>管理画面トップ</title>
    <link rel="stylesheet" href="../CSS/form.css">
</head>

<body>
    <?php if (!empty($_SESSION['administer']['login_id'])) : ?>
        <div class="admin_header">
            <div class="left_column">
                <p>掲示板管理画面メインメニュー</p>
            </div>
            <div class="right_column">
                <p class="friend">ようこそ <?php echo $_SESSION["administer"]["name"] ?> さん</p>
                <input class="button friend" type="button" onclick="location.href='./logout.php'" value="ログアウト">
            </div>
        </div>
        <div class="box">
            <input class="button" type="button" onclick="location.href='./member.php'" value="会員一覧">
        </div>
        <div class="admin_header">

        </div>
    <?php else : ?>
        <div class="admin_header">
            <div class="right_column">
                <input class="button" type="button" onclick="location.href='./login.php'" value="ログイン">
            </div>
        </div>
        <div class="box">
            <p>
                <font size="7">PHP掲示板</font>
            </p>
        </div>
        <div class="admin_header">

        </div>
    <?php endif ?>
</body>

</html>