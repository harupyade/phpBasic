<?php
    var_dump($_POST);

    /* 
    $pageFlag = 0 : 会員情報登録フォーム
    $pageFlag = 1 : 会員情報確認画面
    $pageFlag = 2 : 会員情報完了画面
    */
    $pageFlag = 0;
    if(!empty($_POST['btnConfirm'])){
        $pageFlag = 1;
    }

?>

<!DOCTYPE>
<html>
    <head>
        <title>会員情報登録フォーム</title>
        <link rel="stylesheet" href="../CSS/form.css">
    </head>
    <body>
        <?php
            if($pageFrag == 1){
                include('member_regist_confirm.php');
            }elseif($pageFrag == 2){
                include('member_regist_conplete.php');
            }else{
                include('member_regist_form.php');
            }
        ?>
    </body>
</html>