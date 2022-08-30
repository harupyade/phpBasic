<?php
// 都道府県リスト取得
require_once("./pref_list.php");

// バリデーション取得
require_once("./validation.php");

// 新しいセッションを開始
// リクエスト上で GET, POST またはクッキーにより渡された
// セッション ID に基づき現在のセッションを復帰
session_start();

// セッションで取ってきた中身を変数に代入
$name_sei = $_SESSION['regist']['name_sei'];
$name_mei=$_SESSION['regist']['name_mei'];
$gender=$_SESSION['regist']['gender'];
$pref_num = $_SESSION['regist']['pref_name']; // 都道府県番号取得
$pref_name = $pref_list["$pref_num"]; //都道府県リストから都道府県名取得
$address=$_SESSION['regist']['address'];
$password=$_SESSION['regist']['password']; //セキュリティ上非表示
$email=$_SESSION['regist']['email'];

$errors = memberRegistValidation();

// 「確認画面へ」がクリックされたらmember_regist_confirm.phpに飛ばす
if(!empty($_POST["btn_confirm"]) && !isset($errors)){
    
    // $_SESSIONに$_POSTで取得した情報追加
    $_SESSION["regist"] = $_POST;  

    // このファイルをブラウザに返す
    header('Location: member_regist_confirm.php'); 

    // 現在のスクリプト終了
    exit();
}

// $_SESSIONの中身を確認
// var_dump($_SESSION);
var_dump($errors);

?>

<!DOCTYPE>
<html>
    <head>
        <title>会員情報登録フォーム</title>
        <link rel="stylesheet" href="../CSS/form.css">
    </head>
    <body>
        <h1>会員情報登録フォーム</h1>
        <form action="" method="post">
            <table>
                <!-- 氏名フォーム -->
                <tr>
                    <td>氏名</td>
                    <td>姓<input type="text" name="name_sei">名<input type="text" name="name_mei"></td>
                </tr>
                <!-- 性別選択 -->
                <tr>
                    <td>性別</td>
                    <td><label><input type="radio" name="gender" value="1">男性</label><label><input type="radio" name="gender" value="2">女性</label></td>
                </tr>
                <!-- 住所選択・フォーム -->
                <tr>
                    <td>住所</td>
                    <td>
                        都道府県
                        <select name="pref_name">
                            <?php
                            // foreachでpref_list.php内の$pref_listの中身を取り出し
                            foreach( $pref_list as $key => $value){
                                // 次の画面から戻ってきた時のためのif文
                                if($key == $_POST['pref_name']){
                                    echo "<option value='$key' selected>".$value."</option>";
                                }else{
                                    echo "<option value='$key'>".$value."</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>それ以降の住所<textarea name="address"></textarea></td>
                </tr>
                <!-- パスワードフォーム -->
                <tr>
                    <td>パスワード</td>
                    <td>
                        <input type="password" name="password" value="<?php if(!empty($password)){echo $password;}; ?>">
                    </td>
                </tr>
                <!-- パスワード確認フォーム -->               
                <tr>
                    <td>パスワード確認</td>
                    <td><input type="password" name="password_conf" value="<?php if(!empty($password)){echo $password;}; ?>"></td>
                </tr>
                <!-- メールアドレスフォーム -->
                <tr>
                    <td>メールアドレス</td>
                    <td><input type="text" name="email"></td>
                </tr>
            </table>
            <input type="submit" name="btn_confirm" value="確認画面へ">
        </form>
    </body>
</html>