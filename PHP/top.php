<?php

session_start();
//session_unset();

// $_SESSIONの中身を確認
//var_dump($_SESSION);



?>

<!DOCTYPE>
<html>
    <head>
        <title>トップページ</title>
        <link rel="stylesheet" href="./CSS/form.css">
    </head>
    <body>
        <?php if(!empty($_SESSION['member']['email'])): ?>
            <div class="header">
                <div class = "left_column">
                    <p>ようこそ <?php echo $_SESSION["member"]["name_sei"]." ".$_SESSION["member"]["name_mei"] ?> 様</p>
                </div>
                <div class="right_column">
                    <input class="button" type="button" onclick="location.href='./logout.php'"value="ログアウト">
                </div>
            </div>
            <div class=box>

            </div>
        <?php else: ?>
            <div class="header">
                <div class="right_column">
                    <input class="button" type="button" onclick="location.href='./member_regist.php'"value="新規会員登録">
                    <input class="button" type="button" onclick="location.href='./login.php'"value="ログイン">
                </div>
            </div>
            <div class=box>

            </div>
        <?php endif ?>
    </body>
</html>