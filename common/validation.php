<?php

// 空文字判定1。null は true, "" も true, 0 と "0" は false, " " も false
function is_nullorempty($obj)
{
    if($obj === 0 || $obj === "0"){
        return false;
    }
    return empty($obj);
}

// 空文字判定2。 null は true, "" も true, 0 と "0" is false, " " は true
function is_nullorwhitespace($obj)
{
    if(is_nullorempty($obj) === true){
        return true;
    }
    if(is_string($obj) && mb_ereg_match("^(\s|　)+$", $obj)){
        return true;
    }
    return false;
}


// 値が空かどうかチェックする関数
function empty_check(&$errors, $check_value, $message){
    if (is_nullorwhitespace($check_value)) {
        array_push($errors, $message);
    }
}

// 最小文字数チェックする関数
function string_min_size_check(&$errors, $check_value, $message, $min_size = 8){
    if (mb_strlen($check_value) < $min_size) {
        array_push($errors, $message);
    }
}

// 最大文字数チェックする関数
function string_max_size_check(&$errors, $check_value, $message, $max_size = 255) {
    if ($max_size < mb_strlen($check_value)) {
        array_push($errors, $message);
    }
}

// メールアドレスの形式が正しいかチェックする関数
function mail_address_check(&$errors, $check_value, $message) {
    if (filter_var($check_value, FILTER_VALIDATE_EMAIL) == false) {
        array_push($errors, $message);
    }
}

// パスワードと確認用のパスワードが一致するかチェックする関数
function password_match_check(&$errors, $password, $confirm_password, $message) {
    if (!(strcmp($password, $confirm_password) == 0)) {
        array_push($errors, $message);
    }
}

// 半角英数字で入力されているかチェックする関数
function half_alphanumeric_check(&$errors, $check_value, $message) {
    if (preg_match("/^[a-zA-Z0-9]+$/", $check_value) == false) {
        array_push($errors, $message);
    }
}

// ユーザー名が重複していないかチェックする関数
function name_duplication_check(&$errors, $check_value, $message) {
    $pdo = openDB();
    $sql = 'SELECT id FROM users WHERE `name` = ?';
    $results = queryDB($pdo, $sql, $check_value);

    if ($results) {
        array_push($errors, $message);
    }
}

// メールアドレスが重複していないかチェックする関数
function mail_address_duplication_check(&$errors, $check_value, $message) {
    $pdo = openDB();
    $sql = 'SELECT id FROM users WHERE email = ?';
    $results = queryDB($pdo, $sql, $check_value);

    if ($results) {
        array_push($errors, $message);
    }
}