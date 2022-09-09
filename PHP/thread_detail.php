<?php

echo ini_set('display_errors', 1);

// 関数取得
require_once("./function.php");

session_start();
// 二重送信防止用のトークンの代わり
$_SESSION['token'] = true;
// session_unset();

if (isset($_GET['id'])) {
    $thread_id = $_GET['id'];
}
$member_id = $_SESSION["member"]["id"];

// DB接続
$dbh = new PDO('mysql:dbname=harupyade_test;host=mysql57.harupyade.sakura.ne.jp;charset=utf8', 'harupyade', 'ztrdx_aj4f8ret');

// SQL系のエラー表示
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// スレッドタイトル取り出し
$sql_thread = "SELECT threads.id,threads.member_id,threads.title,threads.content,threads.created_at,members.name_sei,members.name_mei FROM threads JOIN members ON threads.member_id = members.id WHERE threads.id = :id ";
$stmt_thread = $dbh->prepare($sql_thread); // bundValueの前に入れないとエラーになる。
$stmt_thread->bindValue(':id', $thread_id, PDO::PARAM_INT);
$stmt_thread->execute();
$thread = $stmt_thread->fetch(PDO::FETCH_ASSOC);

// コメント取り出し
$sql_comment = "SELECT comments.id,comments.created_at,comments.comment,members.name_sei,members.name_mei FROM comments JOIN members ON comments.member_id = members.id JOIN threads ON comments.thread_id = threads.id where threads.id = :id ";
$stmt_comment = $dbh->prepare($sql_comment);
$stmt_comment->bindValue(':id', $thread_id, PDO::PARAM_INT);
$stmt_comment->execute();
$comments = $stmt_comment->fetchAll(PDO::FETCH_ASSOC);

// コメントのページ切り替え

// コメントの数を数える
$comment_sum = count($comments);
// 最大何ページになるか
$comment_maxpage = ceil($comment_sum / 5);

// もしもpageパラメータが空なら
if (empty($_GET['page'])) {
    $now_page = 0;
} else {
    $now_page = $_GET['page'];
}

// 配列を5個ごとに取得
$comment_no = $now_page * 5;

// array_sliceは、配列の何番目($comment_no)から何番目(MAX)まで切り取る関数
$comments_data = array_slice($comments, $comment_no, 5, true);


// コメント投稿機能
if (!empty($_POST["btn_comment"])) {
    // エラーの初期値
    $errors = array();

    // コメントのバリデーション
    if (empty($_POST['comment'])) {
        $errors['comment'] = "※コメントは必須入力です。";
    } elseif (500 < mb_strlen($_POST['comment'])) {
        $errors['comment'] = "※コメントは500文字以内で入力してください。";
    }

    if (empty($errors)) {
        // $_SESSIONに$_POSTで取得した情報追加
        $_SESSION["comment"] = $_POST;

        if (!empty($_SESSION['token']) && $_SESSION['token'] === true) {

            // セッションの削除
            unset($_SESSION['token']);

            try {
                // データ挿入
                $sql_comment_post = "INSERT INTO comments (member_id,thread_id,comment) VALUES(:member_id,:thread_id,:comment)";
                $stmt_comment_post = $dbh->prepare($sql_comment_post);

                // データ格納
                $stmt_comment_post->bindValue(':member_id', $member_id, PDO::PARAM_INT);
                $stmt_comment_post->bindValue(':thread_id', $thread_id, PDO::PARAM_INT);
                $stmt_comment_post->bindValue(':comment', $_SESSION["comment"]["comment"], PDO::PARAM_STR);

                $stmt_comment_post->execute();
            } catch (PDOException $e) {
                echo ($e->getMessage());
                die();
            }
        } else {
            echo "ERROR：不正な登録処理です";
        }

        // このファイルをブラウザに返す
        header("Location: thread_detail.php?id=" . $thread_id);

        // 現在のスクリプト終了
        exit();
    }
}

// いいね登録・削除機能
if (!empty($_POST["like_on"])) {
    if (empty($_SESSION["member"]["id"])) {
        header("Location:member_regist.php");
    } else {
        // $_SESSIONに$_POSTで取得した情報追加
        $_SESSION["like"] = $_POST;
        $comment_id = $_SESSION["like"]["comment_id"];
        try {
            // データ挿入
            $sql_like_on = "INSERT INTO likes (member_id,comment_id) VALUES(:member_id,:comment_id)";
            $stmt_like_on = $dbh->prepare($sql_like_on);

            // データ格納
            $stmt_like_on->bindValue(':member_id', $member_id, PDO::PARAM_INT);
            $stmt_like_on->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);

            $stmt_like_on->execute();
        } catch (PDOException $e) {
            echo ($e->getMessage());
            die();
        }
        header("Location:thread_detail.php?id=" . $thread_id . "&page=" . $now_page);
        exit();
    }
}
if (!empty($_POST["like_off"])) {
    // $_SESSIONに$_POSTで取得した情報追加
    $_SESSION["like"] = $_POST;
    $comment_id = $_SESSION["like"]["comment_id"];
    try {
        // データ挿入
        $sql_like_off = "DELETE FROM likes WHERE comment_id = :comment_id AND member_id = :member_id";
        $stmt_like_off = $dbh->prepare($sql_like_off);

        // データ格納
        $stmt_like_off->bindValue(':member_id', $member_id, PDO::PARAM_INT);
        $stmt_like_off->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);

        $stmt_like_off->execute();
    } catch (PDOException $e) {
        echo ($e->getMessage());
        die();
    }
    header("Location:thread_detail.php?id=" . $thread_id . "&page=" . $now_page);
    exit();
}



// $_SESSIONの中身を確認
//var_dump($_SESSION);
// var_dump($thread);
// var_dump($comments_data);
// var_dump($_POST); POSTの中身は出てこない
// echo count($comments);
?>

<!DOCTYPE>
<html>

<head>
    <title>スレッド詳細</title>
    <link rel="stylesheet" href="./CSS/form.css">
    <script src="https://kit.fontawesome.com/88a524cdd2.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="header">
        <div class="right_column">
            <input class="button" type="button" onclick="location.href='./thread.php'" value="スレッド一覧に戻る">
        </div>
    </div>
    <div class=box>
        <h1><?php echo $thread["title"] ?></h1>
        <p><?php echo date('Y.m.d H:i', strtotime($thread["created_at"])) ?></p>
        <div class="prev">
            <div class="left_column">
                <?php if ($now_page > 0) : ?>
                    <a href="<?php echo "thread_detail.php?id=" . $thread_id . "&page=" . ($now_page - 1) ?>">
                        <p>＜前へ</p>
                    </a>
                <?php else : ?>
                    <p>＜前へ</p>
                <?php endif ?>
            </div>
            <div class="right_column">
                <?php if ($now_page < $comment_maxpage - 1) : ?>
                    <a href="<?php echo "thread_detail.php?id=" . $thread_id . "&page=" . ($now_page + 1) ?>">
                        <p>次へ＞</p>
                    </a>
                <?php else : ?>
                    <p>次へ＞</p>
                <?php endif ?>
            </div>
        </div>

        <table class="box_blue">
            <thead>
                <th>投稿者：<?php echo $thread["name_sei"] . $thread["name_mei"] . "    " . date('Y.m.d H:i', strtotime($thread["created_at"])) ?></th>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $thread["content"] ?></td>
                </tr>
            </tbody>
        </table>

        <div>
            <table>
                <?php foreach ($comments_data as $comment) : ?>
                    <tbody>
                        <tr>
                            <td><?php echo $comment["id"] . ". " . $comment["name_sei"] . " " . $comment["name_mei"] . "   " . date('Y.m.d H:i', strtotime($comment["created_at"])) ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><?php echo $comment["comment"] ?></td>
                            <td>
                                <!-- いいね機能 -->
                                <form action="" method="post">
                                    <input type="hidden" name="comment_id" value="<?php echo $comment["id"] ?>">
                                    <?php if ((likeMemberGet($comment["id"], $_SESSION["member"]["id"]))) : ?>
                                        <input type="submit" name="like_off" value="&#xf004;" class="fa-solid" style="color:red; background-color: transparent; outline: none; border:none; font-size:15px;">
                                        <!-- クラスを変えると、中の色ありなしを変更可能 -->
                                    <?php else : ?>
                                        <input type="submit" name="like_on" value="&#xf004;" class="fa-regular" style="background-color: transparent; outline: none; border:none; font-size:15px;">
                                    <?php endif ?>
                                </form>
                                <!-- いいね機能ここまで -->
                            </td>
                            <td><?php echo likeCount($comment["id"])["like_count"] ?></td>
                        </tr>
                    </tbody>
                <?php endforeach ?>
            </table>
        </div>
        <div class="prev">
            <div class="left_column">
                <?php if ($now_page > 0) : ?>
                    <a href="<?php echo "thread_detail.php?id=" . $thread_id . "&page=" . ($now_page - 1) ?>">
                        <p>＜前へ</p>
                    </a>
                <?php else : ?>
                    <p>＜前へ</p>
                <?php endif ?>
            </div>
            <div class="right_column">
                <?php if ($now_page < $comment_maxpage - 1) : ?>
                    <a href="<?php echo "thread_detail.php?id=" . $thread_id . "&page=" . ($now_page + 1) ?>">
                        <p>次へ＞</p>
                    </a>
                <?php else : ?>
                    <p>次へ＞</p>
                <?php endif ?>
            </div>
        </div>
        <?php if (!empty($_SESSION)) : ?>
            <form action="" method="post">
                <textarea name="comment"><?php if (!empty($_POST['comment'])) {
                                                echo $_POST['comment'];
                                            } ?></textarea>
                <P style="color:red">
                    <?php
                    if (!empty($errors["comment"])) {
                        echo $errors['comment'];
                    }
                    ?>
                </P>
                <input class="btn_blue" type="submit" name="btn_comment" value="コメントする">
            </form>
        <?php endif ?>
    </div>
</body>

</html>