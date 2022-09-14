<?php
//いつも入れるもの
require_once("../function.php");
session_start();
ini_set('display_errors', 1);

// ここからこのファイルでの操作
require_once("../pref_list.php");

//検索するを押された場合
if (!empty($_POST["btn_confirm"])) {
    // もし検索を押されたときに全部空だった場合
    if (empty($_POST["id"]) && empty($_POST["gender"]) && empty($_POST["pref_name"]) && empty($_POST["free_word"])) {
        $sql_search = "SELECT * FROM members";
    } else {
        // もしどれか1つでも値が入っていた場合
        $sql_search = memberDataGetSearch2((int)$_POST["id"], (int)$_POST["gender"], $_POST["pref_name"], $_POST["free_word"]);
    }
    setcookie('sql_search', "$sql_search", time() + 60 * 60 * 24);
    $get_data = sqlSearch($sql_search);
}

// IDの並び替えを押された場合
if (!empty($_POST["id_order"])) {
    // もしすでにID並び替えボタンが押されていた場合
    if (isset($_COOKIE["id_order"]) && !empty($_COOKIE["id_order"])) {
        // もしすでに入ってるのがASCの場合COOKIEにDESCをセット
        if ($_COOKIE["id_order"] == " ORDER BY id ASC") {
            setcookie('id_order', " ORDER BY id DESC", time() + 60 * 60 * 24);
        } elseif ($_COOKIE["id_order"] == " ORDER BY id DESC") {
            setcookie('id_order', " ORDER BY id ASC", time() + 60 * 60 * 24);
        }
    } // ID並び替えボタンを初めて押された場合
    else {
        setcookie('id_order', " ORDER BY id DESC", time() + 60 * 60 * 24);
    }

    $sql = $_COOKIE["sql_search"] . $_COOKIE["id_order"];
    $get_data = sqlSearch($sql);
} // IDの並び替えを押されていないときにセット
else {
    setcookie('id_order', " ORDER BY id ASC", time() + 60 * 60 * 24);
}

// 登録日時の並び替えを押された場合
if (!empty($_POST["created_order"])) {
    // もしすでにID並び替えボタンが押されていた場合
    if (isset($_COOKIE["created_order"]) && !empty($_COOKIE["created_order"])) {
        // もしすでに入ってるのがASCの場合COOKIEにDESCをセット
        if ($_COOKIE["created_order"] == " ORDER BY created_at ASC") {
            setcookie('created_order', " ORDER BY created_at DESC", time() + 60 * 60 * 24);
        } elseif ($_COOKIE["created_order"] == " ORDER BY created_at DESC") {
            setcookie('created_order', " ORDER BY created_at ASC", time() + 60 * 60 * 24);
        }
    } // ID並び替えボタンを初めて押された場合
    else {
        setcookie('created_order', " ORDER BY created_at DESC", time() + 60 * 60 * 24);
    }
    $sql = $_COOKIE["sql_search"] . $_COOKIE["created_order"];
    $get_data = sqlSearch($sql);
} // 登録日時の並び替えを押されていないときにセット
else {
    setcookie('created_order', " ORDER BY created_at ASC", time() + 60 * 60 * 24);
}

// 何も押されていない場合のセット
if(empty($_POST["btn_confirm"]) && empty($_POST["id_order"]) && empty($_POST["created_order"])){
    $sql = "SELECT * FROM members";
    $get_data = sqlSearch($sql);
}

var_dump($_COOKIE);
//echo $sql;
//echo $get_data;
//var_dump($get_data);
//var_dump($_POST);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>会員一覧ページ</title>
    <link rel="stylesheet" href="../CSS/form.css">
    <script src="https://kit.fontawesome.com/88a524cdd2.js" crossorigin="anonymous"></script>
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
                    <td><label><input type="radio" name="gender" value="1">男性</label><label><input type="radio" name="gender" value="2">女性</label></td>
                </tr>
                <tr>
                    <td>都道府県</td>
                    <td><select name="pref_name">
                            <?php
                            // foreachでpref_list.php内の$pref_listの中身を取り出し
                            foreach ($pref_list as $key => $value) {
                                if (empty($key)) {
                                    echo "<option value=''>" . $value . "</option>";
                                } else {
                                    echo "<option value='$value'>" . $value . "</option>";
                                }
                            }
                            ?>
                        </select></td>
                </tr>
                <tr>
                    <td>フリーワード</td>
                    <td><input type="text" name="free_word" value=""></td>
                </tr>
            </table>
            <input class="btn_blue" type="submit" name="btn_confirm" value="検索する">
        </form>
        <table>
            <thead>
                <tr>
                    <form action="" method="post">
                        <th id="id_order">ID
                            <!-- もしもクッキーに値が入っていた場合 -->
                            <?php if (isset($_COOKIE["id_order"]) && !empty($_COOKIE["id_order"])) : ?>
                                <?php if ($_COOKIE["id_order"] == " ORDER BY id ASC") : ?>
                                    <input type="submit" name="id_order" value="△" style="background-color: transparent; outline: none; border:none;">
                                <?php elseif ($_COOKIE["id_order"] == " ORDER BY id DESC") : ?>
                                    <input type="submit" name="id_order" value="▽" style="background-color: transparent; outline: none; border:none;">
                                <?php endif ?>
                            <?php else : ?>
                                <input type="submit" name="id_order" value="▽" style="background-color: transparent; outline: none; border:none;">
                            <?php endif ?>
                        </th>
                    </form>
                    <th>氏名</th>
                    <th>性別</th>
                    <th>住所</th>
                    <form action="" method="post">
                        <th id="created_order">登録日時
                            <!-- もしもクッキーに値が入っていた場合 -->
                            <?php if (isset($_COOKIE["created_order"]) && !empty($_COOKIE["created_order"])) : ?>
                                <?php if ($_COOKIE["created_order"] == " ORDER BY created_at ASC") : ?>
                                    <input type="submit" name="created_order" value="△" style="background-color: transparent; outline: none; border:none;">
                                <?php elseif ($_COOKIE["created_order"] == " ORDER BY created_at DESC") : ?>
                                    <input type="submit" name="created_order" value="▽" style="background-color: transparent; outline: none; border:none;">
                                <?php endif ?>
                            <?php else : ?>
                                <input type="submit" name="created_order" value="▽" style="background-color: transparent; outline: none; border:none;">
                            <?php endif ?>
                        </th>
                    </form>
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