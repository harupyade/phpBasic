<?php

// エラー表示
ini_set('display_errors', 1);


// 新しいセッションを開始
// リクエスト上で GET, POST またはクッキーにより渡された
// セッション ID に基づき現在のセッションを復帰
session_start();

// 二重送信防止用のトークンの代わり
$_SESSION['token'] = true;

// セッション使用時にブラウザキャッシュを有効にする
header('Expires: -1');
header('Cache-Control:');
header('Pragma:');

$member_id = $_SESSION['member']['id'];
$title = $_SESSION['thread']['title'];
$content = $_SESSION['thread']['content'];

if(!empty($_POST["btn_end"])){
    session_start();
    if( !empty($_SESSION['token'] && $_SESSION['token'] === true )){
        // セッションの削除
		unset($_SESSION['token']);

        try{
            // DB接続
            $dbh = new PDO('mysql:dbname=harupyade_test;host=mysql57.harupyade.sakura.ne.jp;charset=utf8', 'harupyade', 'ztrdx_aj4f8ret');
        
            // データ挿入
            $sql = "INSERT INTO threads (member_id,title,content) VALUES(:member_id,:title,:content)";
            $stmt = $dbh->prepare($sql);

            // データ格納
            $stmt->bindValue( ':member_id',$member_id,PDO::PARAM_STR);
            $stmt->bindValue( ':title', $title, PDO::PARAM_STR);
            $stmt->bindValue( ':content', $content, PDO::PARAM_STR);

            $stmt -> execute();
        } catch (PDOException $e) {
            echo ($e->getMessage());
            die();
        }

        // このファイルをブラウザに返す
        header('Location: top.php'); 
    
        // 現在のスクリプト終了
        exit();

    } else {
        echo"ERROR：不正な登録処理です";
    }

}

// エラー表示
ini_set('display_errors', 1);

var_dump($_SESSION);

?>

<!DOCTYPE>
<html>
    <head>
        <title>スレッド作成確認画面</title>
        <link rel="stylesheet" href="./CSS/form.css">
    </head>
    <body>
    <div class="box">
        <h1>スレッド作成確認画面</h1>
        <form action="" method="post">
            <table>
                <!-- スレッドタイトル -->
                <tr>
                    <td>スレッドタイトル</td>
                    <td><?php echo $title ?></td>
                </tr>
                <tr>
                    <td>コメント</td>
                    <td><?php echo nl2br($content) ?></td>
                </tr>
            </table>
            <input type="hidden" name="token">
            <input type="submit" name="btn_end" value="登録完了">
            <button type="button" onclick="history.back()">前に戻る</button>
        </form>
    </div>
    </body>
</html>