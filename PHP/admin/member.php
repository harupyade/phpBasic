<?php
//いつも入れるもの
require_once("../function.php");
session_start();
ini_set('display_errors', 1);

// ここからこのファイルでの操作
require_once("../pref_list.php");
if(!empty($_POST["btn_confirm"])){
    $get_data = memberDataGetSearch((int)$_POST["id"],$_POST["gender"],$_POST["pref_name"],$_POST["free_word"]);
    if(empty($_POST["id"])&&empty($_POST["gender"])&&empty($_POST["pref_name"])&&empty($_POST["free_word"])){
        $get_data = memberDataGet();
    }
}else{
    $get_data = memberDataGet();
}

var_dump($get_data);
var_dump($_POST);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>会員一覧ページ</title>
    <link rel="stylesheet" href="../CSS/form.css">
</head>

<body>
    <div class="admin_header">
        <div class="left_column">
            <p>会員一覧</p>
        </div>
        <div class="right_column">
            <input class="button" type="button" onclick="location.href='./top.php'" value="トップへ戻る">
        </div>
    </div>
    <div class="box">
        <!-- 検索フォーム -->
        <form action="" method="post">
            <table>
                <tr>
                    <td>ID</td>
                    <td><input type="text" name="id" value=""></td>
                </tr>
                <tr>
                    <td>性別</td>
                    <td><label><input type="radio" name="gender" value="1" >男性</label><label><input type="radio" name="gender" value="2" >女性</label></td>
                </tr>
                <tr>
                    <td>都道府県</td>
                    <td><select name="pref_name">
                            <?php
                            // foreachでpref_list.php内の$pref_listの中身を取り出し
                            foreach ($pref_list as $key => $value) {
                                    echo "<option value='$value'>" . $value . "</option>";
                            }
                            ?>
                        </select></td>
                </tr>
                <tr>
                    <td>フリーワード</td>
                    <td><input type="text" name="free_word" value="<?php if (!empty($_POST['free_word'])) {
                                                                        echo $_POST['free_word'];
                                                                    } ?>"></td>
                </tr>
            </table>
            <input class="btn_blue" type="submit" name="btn_confirm" value="検索する" >
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>氏名</th>
                    <th>性別</th>
                    <th>住所</th>
                    <th>登録日時</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($get_data as $data) : ?>
                    <tr>
                        <td><?php echo $data["id"] ?></td>
                        <td><?php echo $data["name_sei"] . $data["name_mei"] ?></td>
                        <?php if ($data["gender"] == 2) : ?>
                            <td>女性</td>
                        <?php else : ?>
                            <td>男性</td>
                        <?php endif ?>
                        <td><?php echo $data["pref_name"] . $data["address"] ?></td>
                        <td><?php echo $data["created_at"] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</body>

</html>