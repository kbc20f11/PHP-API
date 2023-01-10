<?php
require_once('common/config.php');
require_once('common/database.php');

// CORS対策
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding, X-Requested-With, Origin, X-Csrftoken, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, CONNECT, OPTIONS, TRACE, PATCH, HEAD");

// プリフライトリクエスト対策
if( $_SERVER['REQUEST_METHOD'] === "OPTIONS" ){
    exit;
}

// 文字コード対策
mb_language('uni');
mb_internal_encoding('utf-8'); 
mb_http_input('auto');
mb_http_output('utf-8');

// delete以外のメソッドの時
if ($_SERVER["REQUEST_METHOD"] != "DELETE"){
    http_response_code(400);
    echo('error');
    die();
}

// クエリパラメーターを取得
$id = filter_input(INPUT_GET, 'id');

// postされた値が取得できなかった場合は終了
// if (!$id){
//     echo('error');
//     die();
// }

// postされたjsonを取得、デシリアライズ
// 
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// データベース接続
$pdo = openDB();

// sql文
$sql = "update bicycles SET deleted_at=CURRENT_TIMESTAMP where `id` = ?";

// クエリ実行
execDB($pdo, $sql, $id);
