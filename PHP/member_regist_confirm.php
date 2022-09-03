<?php

// 都道府県リスト取得
require_once("./pref_list.php");

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

// $_SESSIONの中身を確認
// var_dump($_SESSION);
// echo $_SESSION['token'];

// セッションで取ってきた中身を変数に代入
$name_sei = $_SESSION['regist']['name_sei'];
$name_mei=$_SESSION['regist']['name_mei'];
$gender=$_SESSION['regist']['gender'];
$pref_num = $_SESSION['regist']['pref_name']; // 都道府県番号取得
$pref_name = $pref_list["$pref_num"]; //都道府県リストから都道府県名取得
$address=$_SESSION['regist']['address'];
$password=$_SESSION['regist']['password']; //セキュリティ上非表示
$email=$_SESSION['regist']['email'];


// 「登録完了」がクリックされたらmember_regist_end.phpに飛ばす
if(!empty($_POST["btn_end"])){

    session_start();
    if( !empty($_SESSION['page']) && $_SESSION['page'] === true ) {

		// セッションの削除
		unset($_SESSION['page']);
    
        try{
            // DB接続
            $dbh = new PDO('mysql:dbname=harupyade_test;host=mysql57.harupyade.sakura.ne.jp;charset=utf8', 'harupyade', 'ztrdx_aj4f8ret');
        
            // データ挿入
            $sql = "INSERT INTO members (name_sei,name_mei,gender,pref_name,address,password,email) VALUES(:name_sei,:name_mei,:gender,:pref_name,:address,:password,:email)";
            $stmt = $dbh->prepare($sql);
        
            // データ格納
            $stmt->bindValue( ':name_sei',$name_sei,PDO::PARAM_STR);
            $stmt->bindValue( ':name_mei', $name_mei, PDO::PARAM_STR);
            $stmt->bindValue( ':gender', $gender, PDO::PARAM_INT);
            $stmt->bindValue( ':pref_name', $pref_name, PDO::PARAM_STR);
            $stmt->bindValue( ':address', $address, PDO::PARAM_STR);
            $stmt->bindValue( ':password', $password, PDO::PARAM_STR);
            $stmt->bindValue( ':email', $email, PDO::PARAM_STR);
        
            $stmt -> execute();
        
        } catch (PDOException $e) {
            echo ($e->getMessage());
            die();
        }
    
        // このファイルをブラウザに返す
        header('Location: member_regist_end.php'); 
    
        // 現在のスクリプト終了
        exit();

    } else {
        echo"ERROR：不正な登録処理です";
    }

    
}

?>

<!DOCTYPE>
<html>
    <head>
        <title>会員情報確認画面</title>
        <link rel="stylesheet" href="./CSS/form.css">
    </head>
    <body>
        <p><?php echo $_SESSION['token']  ?></p>
    <div class=box>
        <h1>会員情報確認画面</h1>
        <form action="" method="post">
            <table>
                <!-- 氏名フォーム -->
                <tr>
                    <td>氏名</td>
                    <td>姓 <?php echo $name_sei ?> 名 <?php echo $name_mei ?></td>
                </tr>
                <!-- 性別選択 -->
                <tr>
                    <td>性別</td>
                    <td>
                        <?php 
                        if($gender == 1){
                            echo "男性";
                        }elseif($gender == 2){
                            echo "女性";
                        }else{
                            echo "エラー";
                        }
                        ?>
                    </td>
                </tr>
                <!-- 住所選択・フォーム -->
                <tr>
                    <td>住所</td>
                    <td><?php echo $pref_name.$address ?></td>
                </tr>
                <!-- パスワードフォーム -->
                <tr>
                    <td>パスワード</td>
                    <td>セキュリティのため非表示</td>
                </tr>
                <!-- メールアドレスフォーム -->
                <tr>
                    <td>メールアドレス</td>
                    <td><?php echo $email ?></td>
                </tr>
            </table>
            <!-- hidden要素にPOSTするトークンセット -->
            <input type="hidden" name="token" value="<?php echo $token;?>">
            <input type="submit" name="btn_end" value="登録完了">

            <!-- onclickは、ボタンクリック時に実行するJavaScriptを指定するために利用
            historyオブジェクトはJavaSiptからブラウザの閲覧履歴へアクセスするために利用 -->
            <button type="button" onclick="history.back()">前に戻る</button>
        </form>
    </div>
    <!-- .boxここまで -->
    </body>
</html>