<?php

function memberRegistValidation(){

    // エラーの初期値
    $errors = array();

    //氏名のバリデーション
    if(!isset($_SESSION['regist']['name_sei'])){
        $errors['name_sei'] = "氏名（姓）は必須入力です";
    }elseif( 20 < mb_strlen($data['name_sei']) ) {
		$errors['name_sei'] = "氏名（姓）は20文字以内で入力してください。";
	}

    if(!isset($_SESSION['regist']['name_mei'])) {
		$errors['name_mei'] = "氏名（名）は必須入力です";

        // ▼mb_strlenとすることで全角でも1文字カウント
	}elseif( 20 < mb_strlen($_SESSION['regist']['name_mei']) ) {
		$errors['name_mei'] = "氏名（名）は20文字以内で入力してください。";
	}

    // 性別のバリデーション
    if(!isset($_SESSION['regist']['gender'])){
        $errors['gender'] = "性別は必須入力です。";
    }elseif($_SESSION['regist']['gender'] != 1 && $_SESSION['regist']['gender'] != 2){
        $errors['gender'] = "性別を正しく入力してください。";
    }

    return $errors;

}

?>