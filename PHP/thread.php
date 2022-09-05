<?php
// 関数取得
require_once("./function.php");

// 新しいセッションを開始
// リクエスト上で GET, POST またはクッキーにより渡された
// セッション ID に基づき現在のセッションを復帰
session_start();
// エラー表示
ini_set('display_errors', 1);

$get_data = search($_POST['btn_search'],$_POST['search']);

// $_SESSIONの中身を確認
//var_dump($_SESSION);
// echo('<pre>');
// var_dump($get_data);
// echo('</pre>');
//echo $_POST['btn_search'];

?>

<!DOCTYPE>
<html>
    <head>
        <title>スレッド一覧</title>
        <link rel="stylesheet" href="./CSS/form.css">
    </head>
    <body>
    <div class="header">
        <div class="right_column">
            <?php if(!empty($_SESSION["member"])): ?>
                <input class="button" type="button" onclick="location.href='./thread_regist.php'"value="新規スレッド作成">
            <?php endif ?>
        </div>
    </div>
    <div class="box">
        <!-- 検索フォーム -->
        <form action="" method="post">
            <input type="text" name="search" value="<?php if( !empty($_POST['search']) ){ echo $_POST['search']; } ?>">
            <input type="submit" name="btn_search" value="スレッド検索">
        </form>
        <table>
            <?php foreach($get_data as $data): ?>
            <tr>
                <td>ID:<?php echo $data["id"] ?></td>
                <td><?php echo $data["title"] ?></td>
                <td><?php echo date('Y.m.d H:i',strtotime($data["created_at"])) ?></td>
            </tr>
            <?php endforeach ?>
        </table>
        <input class="btn_blue" type="button" onclick="location.href='./top.php'"value="トップに戻る">
    </div>
        
    </body>
</html>