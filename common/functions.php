<?php
// 文字列をエスケープ
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES);
}

// 文字列をフィルター
function f($type, $string) {
    return trim(filter_input($type, $string));
}

// csrf tokenの作成
function generate_token() {
    if(!isset($_SESSION)){
        session_start();
    }
    if (!isset($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
}

// csrf tokenの検証
function validate_token() {
    if(!isset($_SESSION)){
        session_start();
    }
    if (empty($_SESSION['token']) || $_SESSION['token'] !== filter_input(INPUT_POST, 'token')) {
        die();
    }

}

?>