<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
// DB接続
function dbConnect(){
    $dsn = 'mysql:dbname=harupyade_test;host='.$_ENV['db_host'].';';
    $user = $_ENV['db_user'];
    $password = $_ENV['db_pass'];
    try{
        $dbh = new PDO($dsn,$user,$password);
        return $dbh;
    }catch (PDOException $e) {
        echo "接続失敗: " . $e->getMessage() . "\n";
        exit();
    }
}

//メールアドレスの存在確認 & ソフトデリートされていない会員
function emailExists($email)
{
    // DB接続
    $dbh = dbConnect();
    // SQL
    $sql = "SELECT COUNT(id) FROM members WHERE email = :email AND deleted_at IS NULL";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // fetch：見つかった1行を取ってくるイメージ
    // PDO::FETCH_ASSOC: は、結果セットに 返された際のカラム名で添字を付けた配列を返します。
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($count['COUNT(id)'] > 0) {
        // TRUEならエラーメッセージ
        return TRUE;
    } else {
        return FALSE;
    }
}

// 会員情報取り出し
function memberInfo($email)
{
    // DB接続
    $dbh = dbConnect();
    // SQL
    $sql = "SELECT * FROM members WHERE email = :email";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $get_data = $stmt->fetch(PDO::FETCH_ASSOC);
    return $get_data;
}

// 会員退会機能
function memberWithdrawal($id)
{
    // DB接続
    $dbh = dbConnect();
    // SQL
    $sql = "UPDATE members SET deleted_at = CURRENT_TIMESTAMP WHERE id=:id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        return TRUE;
    } else {
        return FALSE;
    }
}

// スレッド検索機能
function search($btn, $search)
{
    $get_data = [];
    // DB接続
    $dbh = dbConnect();

    // もし検索ボタンが押されてなければ
    if (!empty($btn)) {
        // SQL
        $sql = "SELECT * FROM threads WHERE CONCAT(title, content) LIKE :search ORDER BY created_at DESC";
        $stmt = $dbh->prepare($sql); // bundValueの前に入れないとエラーになる。
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    } else {
        $sql = "SELECT * FROM threads ORDER BY created_at DESC";
        $stmt = $dbh->prepare($sql);
    }
    $stmt->execute();
    $get_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $get_data;
}

// いいねの回数カウント機能
function likeCount($comment_id)
{
    // DB接続
    $dbh = dbConnect();
    // SQL
    $sql = "SELECT COUNT(*) AS like_count FROM likes WHERE comment_id = :comment_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
    $stmt->execute();
    $get_data = $stmt->fetch();
    return $get_data;
}

// 自分がいいねしているかどうかの判別機能
function likeMemberGet($comment_id, $member_id)
{
    // DB接続
    $dbh = dbConnect();
    // SQL
    $sql = "SELECT id FROM likes WHERE comment_id = :comment_id AND member_id = :member_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
    $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
    $stmt->execute();
    $get_data = $stmt->fetch();
    return $get_data;
}
