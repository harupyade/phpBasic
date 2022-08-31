<?php

ini_set('display_errors', 1);

// 都道府県リスト取得
require_once("./pref_list.php");

// 新しいセッションを開始
// リクエスト上で GET, POST またはクッキーにより渡された
// セッション ID に基づき現在のセッションを復帰
session_start();
// セッション使用時にブラウザキャッシュを有効にする
// 下3行がないと、前に戻るボタンでエラーがが発生する
header('Expires: -1');
header('Cache-Control:');
header('Pragma:');

// 「確認画面へ」がクリックされたらmember_regist_confirm.phpに飛ばす
if(!empty($_POST["btn_confirm"])){

    // エラーの初期値
    $errors = array();

    //氏名のバリデーション
    if( empty($_POST['name_sei'])){
        $errors['name_sei'] = "※氏名（姓）は必須入力です";
        // ▼mb_strlenとすることで全角でも1文字カウント
    }elseif( 20 < mb_strlen($_POST['name_sei']) ) {
		$errors['name_sei'] = "※氏名（姓）は20文字以内で入力してください。";
	}

    if( empty($_POST['name_mei'])) {
		$errors['name_mei'] = "※氏名（名）は必須入力です";
	}elseif( 20 < mb_strlen($_POST['name_mei']) ) {
		$errors['name_mei'] = "※氏名（名）は20文字以内で入力してください。";
	}

    // 性別のバリデーション
    if( empty($_POST['gender'])){
        $errors['gender'] = "※性別は必須入力です。";
    }elseif($_POST['gender'] != 1 && $_POST['gender'] != 2){
        $errors['gender'] = "※性別を正しく入力してください。";
    }
    
    // 住所のバリデーション
	if( empty($_POST['pref_name']) ) {
		$errors['pref_name'] = "※都道府県は必須入力です";
	}elseif( (int)$_POST['pref_name'] < 01 || 47 < (int)$_POST['pref_name'] ) {
		$errors['pref_name'] = "※都道府県は必須入力です。";
	}

    if(100 < mb_strlen($data['address']) ) {
		$errors['pref_name'] = "※住所は100文字以内で入力してください。";
	}
	

	// パスワードのバリデーション
	if( empty($_POST['password']) ) {
		$errors['password'] = "※パスワードは必須入力です";
	}elseif( !preg_match( '/^[0-9a-z]/', $_POST['password']) ) {
		$errors['password'] = "※パスワードは半角英数字で入力してください。";
	}elseif( 20 < mb_strlen($_POST['password']) ) {
		$errors['password'] = "※パスワードは8文字以上20文字以内で入力してください。";
	}elseif( 8 > mb_strlen($_POST['password']) ) {
		$errors['password'] = "※パスワードは8文字以上20文字以内で入力してください。";
	}
    
    if( empty($_POST['password_conf']) ) {
		$errors['password_conf'] = "※パスワードは必須入力です";
	}elseif( !preg_match( '/^[0-9a-z]/', $_POST['password']) ) {
		$errors['password_conf'] = "※パスワードは半角英数字で入力してください。";
	}elseif( 20 < mb_strlen($_POST['password']) || 8 > mb_strlen($_POST['password']) ) {
		$errors['password_conf'] = "※パスワードは8文字以上20文字以内で入力してください。";
    //}elseif( 8 > mb_strlen($_POST['password']) ) {
		//$errors['password'] = "※パスワードは8文字以上20文字以内で入力してください。";
	}elseif($_POST['password'] != $_POST['password_conf']){
        $errors['password_conf']="※確認用パスワードと異なっています。";
    }

	// メールアドレスのバリデーション
	if( empty($_POST['email']) ) {
		$errors['email'] = "※メールアドレスは必須入力です。";
	}elseif( !preg_match( '/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $_POST['email']) ) {
		$errors['email'] = "※メールアドレスは正しい形式で入力してください。";
	}elseif( 200 < mb_strlen($_POST['email']) ) {
		$errors['email'] = "※メールアドレス200文字以内で入力してください。";
	}


    if(empty($errors)){
        // $_SESSIONに$_POSTで取得した情報追加
        $_SESSION["regist"] = $_POST;  

        // このファイルをブラウザに返す
        header('Location: member_regist_confirm.php'); 

        // 現在のスクリプト終了
        exit();
    }

}

// $_SESSIONの中身を確認
var_dump($_SESSION);
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
                    <td>姓<input type="text" name="name_sei" value="<?php if( !empty($_POST['name_sei']) ){ echo $_POST['name_sei']; } ?>">名<input type="text" name="name_mei" value="<?php if( !empty($_POST['name_mei']) ){ echo $_POST['name_mei']; } ?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="color:red">
                        <?php 
                            if(!empty($errors["name_sei"]) && !empty($errors["name_mei"])){
                                echo $errors['name_sei']."</br>".$errors['name_mei'];
                            }elseif(!empty($errors["name_sei"])){
                                echo $errors['name_sei'];
                            }elseif(!empty($errors["name_mei"])){
                                echo $errors['name_mei'];
                            }
                        ?>
                    </td>
                </tr>
                <!-- 性別選択 -->
                <tr>
                    <td>性別</td>
                    <td><label><input type="radio" name="gender" value="1" <?php if( !empty($_POST['gender']) && $_POST['gender'] === "1" ){ echo 'checked'; } ?>>男性</label><label><input type="radio" name="gender" value="2" <?php if( !empty($_POST['gender']) && $_POST['gender'] === "2" ){ echo 'checked'; } ?>>女性</label></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="color:red">
                        <?php 
                            if(!empty($errors["gender"])){
                                echo $errors['gender'];
                            }
                        ?>
                    </td>
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
                    <td>それ以降の住所<textarea name="address"><?php if( !empty($_POST['address']) ){ echo $_POST['address']; } ?></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="color:red">
                        <?php 
                            if(!empty($errors["pref_name"]) && !empty($errors["address"])){
                                echo $errors['pref_name']."</br>".$errors['address'];
                            }elseif(!empty($errors["pref_name"])){
                                echo $errors['pref_name'];
                            }elseif(!empty($errors["address"])){
                                echo $errors['address'];
                            }
                        ?>
                    </td>
                </tr>
                <!-- パスワードフォーム -->
                <tr>
                    <td>パスワード</td>
                    <td>
                        <input type="password" name="password" value="<?php if( !empty($_POST['password']) ){ echo $_POST['password']; }elseif(!empty($_SESSION['password'])){echo $_SESSION['password'];} ?>">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="color:red">
                        <?php 
                            if(!empty($errors["password"])){
                                echo $errors['password'];
                            }
                        ?>
                    </td>
                </tr>
                <!-- パスワード確認フォーム -->               
                <tr>
                    <td>パスワード確認</td>
                    <td><input type="password" name="password_conf" value="<?php if( !empty($_POST['password_conf']) ){ echo $_POST['password_conf']; }elseif(!empty($_SESSION['password_conf'])){echo $_SESSION['password_conf'];} ?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="color:red">
                        <?php 
                            if(!empty($errors["password_conf"])){
                                echo $errors['password_conf'];
                            }
                        ?>
                    </td>
                </tr>
                <!-- メールアドレスフォーム -->
                <tr>
                    <td>メールアドレス</td>
                    <td><input type="text" name="email" value="<?php if( !empty($_POST['email']) ){ echo $_POST['email']; } ?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="color:red">
                        <?php 
                            if(!empty($errors["email"])){
                                echo $errors['email'];
                            }
                        ?>
                    </td>
                </tr>
            </table>
            <input type="submit" name="btn_confirm" value="確認画面へ"  >
        </form>
    </body>
</html>