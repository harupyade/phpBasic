<?php
//いつも入れるもの
require_once("../function.php");
session_start();
ini_set('display_errors', 1);

//session_unset();
// ここからこのファイルでの操作
require_once("../pref_list.php");
if (!empty($_POST["btn_confirm"])) {
    // $_SESSION["sql"]に sql文を代入
    $_SESSION["sql"] = memberDataGetSearch2((int)$_POST["id"], (int)$_POST["gender"], $_POST["pref_name"], $_POST["free_word"]);
    // $_SESSION["get_data"] = $get_data;
    if (empty($_POST["id"]) && empty($_POST["gender"]) && empty($_POST["pref_name"]) && empty($_POST["free_word"])) {
        $_SESSION["sql"] = "SELECT * FROM members";
    }
    $get_data = sqlSearch($_SESSION["sql"]);
}
// else {
//     $_SESSION["sql"] = "SELECT * FROM members";
//     $get_data = sqlSearch($_SESSION["sql"]);
// }



// $sql の値を代入
// idの並び替えボタンを押した時でかつ$_SESSION["id_order"]のセットがされている時交互に入れ替え
if (!empty($_POST["id_order"]) && isset($_SESSION["id_order"]) && !empty($_SESSION["id_order"] == "ASC")) {
    $_SESSION["id_order"] = "DESC";
    $sql = $_SESSION["sql"] . " ORDER BY id DESC";
    $get_data = sqlSearch($sql);
} elseif (!empty($_POST["id_order"]) && $_SESSION["id_order"] == "DESC") {
    $_SESSION["id_order"] = "ASC";
    $sql = $_SESSION["sql"] . " ORDER BY id ASC";
    $get_data = sqlSearch($sql);
}
// if (!empty($_POST["created_order"]) && isset($_SESSION["created_order"]) && !empty($_SESSION["created_order"] == "ASC")) {
//     $_SESSION["created_order"] = "DESC";
//     $sql = $_SESSION["sql"] . " ORDER BY created_at DESC";
//     $get_data = sqlSearch($sql);
// } elseif (!empty($_POST["created_order"])  && $_SESSION["created_order"] == "DESC") {
//     $_SESSION["created_order"] = "ASC";
//     $sql = $_SESSION["sql"] . " ORDER BY created_at ASC";
//     $get_data = sqlSearch($sql);
// }
// else{
//     $_SESSION["id_order"] = "DESC";
//     $sql = $_SESSION["sql"]." ORDER BY id DESC"; 
// }

if (empty($_POST)) {
    $sql = "SELECT * FROM members";
    $get_data = sqlSearch($sql);
}


//echo $_SESSION["id_order"];
var_dump($_SESSION);
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
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        // $(fuction(){
        //     $("#id_order").toggle(
        //         function(){
        //             $(this).children('i').html("あ");
        //         },ïïï
        //         function(){
        //             $(this).children('i').html("い");
        //         }
        //     );
        // });


        // $(function() {

        //     $("#id_order").click(function() {
        //         if ($(this).children('i').hasClass('fa-sort-up')) {
        //             $(this).children('i').removeClass("fa-sort-up");
        //             $(this).children('i').addClass("fa-sort-down");
        //         } else {
        //             $(this).children('i').removeClass("fa-sort-down");
        //             $(this).children('i').addClass("fa-sort-up");
        //         }
        //     });

        //     $("#created_order").click(function() {
        //         if ($(this).children('i').hasClass('fa-sort-up')) {
        //             $(this).children('i').removeClass("fa-sort-up");
        //             $(this).children('i').addClass("fa-sort-down");
        //         } else {
        //             $(this).children('i').removeClass("fa-sort-down");
        //             $(this).children('i').addClass("fa-sort-up");
        //         }
        //     });

        // });
    </script>
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
                            <?php if ($_SESSION["id_order"] == "ASC") : ?>
                                <input type="submit" name="id_order" value="△" style="background-color: transparent; outline: none; border:none;">
                            <?php elseif (empty($_POST["id_order"]) || $_SESSION["id_order"] == "DESC") : ?>
                                <input type="submit" name="id_order" value="▽" style="background-color: transparent; outline: none; border:none;">
                            <?php endif ?>
                        </th>
                    </form>
                    <th>氏名</th>
                    <th>性別</th>
                    <th>住所</th>
                    <form action="" method="post">
                        <th id="created_order">登録日時
                            <?php if ( $_SESSION["created_order"] == "ASC") : ?>
                                <input type="submit" name="created_order" value="△" style="background-color: transparent; outline: none; border:none;">
                            <?php elseif (empty($_POST["created_order"]) || $_SESSION["created_order"] == "DESC") : ?>
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