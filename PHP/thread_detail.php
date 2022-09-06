<?php
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

// DB接続
$dbh = new PDO('mysql:dbname=harupyade_test;host=mysql57.harupyade.sakura.ne.jp;charset=utf8', 'harupyade', 'ztrdx_aj4f8ret');


// スレッドタイトル取り出し
$sql = "SELECT threads.id,threads.member_id,threads.title,threads.content,threads.created_at,members.name_sei,members.name_mei FROM threads JOIN members ON threads.member_id = members.id WHERE threads.id = :id ";
$stmt = $dbh->prepare($sql); // bundValueの前に入れないとエラーになる。
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$thread = $stmt->fetch(PDO::FETCH_ASSOC);

// $_SESSIONの中身を確認
// var_dump($_SESSION);
// var_dump($thread);

?>

<!DOCTYPE>
<html>

<head>
    <title>スレッド詳細</title>
    <link rel="stylesheet" href="./CSS/form.css">
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

        </div>
        <div>
            <table>
                <thead>
                    <th>投稿者：<?php echo $thread["name_sei"] . $thread["name_mei"] . "    " . date('Y.m.d H:i', strtotime($thread["created_at"])) ?></th>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $thread["content"] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="prev">

        </div>
        <?php if (!empty($_SESSION)) : ?>
            <form action="" method="post">
                <textarea></textarea>
                <input class="btn_blue" type="submit" name="btn_comment" value="コメントする">
            </form>
        <?php endif ?>
    </div>
</body>

</html>