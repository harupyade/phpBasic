<?php

   //メールアドレスの存在確認
   function emailExists($email){
    // DB接続
    $dbh = new PDO('mysql:dbname=harupyade_test;host=mysql57.harupyade.sakura.ne.jp;charset=utf8', 'harupyade', 'ztrdx_aj4f8ret');
	// SQL
    $sql = "SELECT COUNT(id) FROM members WHERE email = :email";
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':email', $email,PDO::PARAM_STR);
	$stmt->execute();

    // fetch：見つかった1行を取ってくるイメージ
    // PDO::FETCH_ASSOC: は、結果セットに 返された際のカラム名で添字を付けた配列を返します。
	$count = $stmt-> fetch(PDO::FETCH_ASSOC);
	if($count['COUNT(id)'] > 0){
        // TRUEならエラーメッセージ
		return TRUE;
	}else{
		return FALSE;
	}

    }

    // 会員情報取り出し
    function memberInfo($email){
        // DB接続
        $dbh = new PDO('mysql:dbname=harupyade_test;host=mysql57.harupyade.sakura.ne.jp;charset=utf8', 'harupyade', 'ztrdx_aj4f8ret');
        // SQL
        $sql = "SELECT * FROM members WHERE email = :email";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':email', $email,PDO::PARAM_STR);
        $stmt->execute();
        $get_data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $get_data;
    }

?>