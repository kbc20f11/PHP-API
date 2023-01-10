<?php
require_once('common/config.php');
require_once('common/database.php');

// CORS対策
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding, X-Requested-With, Origin, X-Csrftoken, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, CONNECT, OPTIONS, TRACE, PATCH, HEAD");

if( $_SERVER['REQUEST_METHOD'] === "OPTIONS" ){
    exit;
}

// 文字コード対策
mb_language('uni');
mb_internal_encoding('utf-8'); 
mb_http_input('auto');
mb_http_output('utf-8');

// post以外のメソッドの時
if ($_SERVER["REQUEST_METHOD"] != 'POST'){
    http_response_code(400);
    echo('error');
    die();
}

// postされた値を取得
// $id = filter_input(INPUT_POST, 'id');

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
$sql = "update bicycles SET `name`=?, `description`=?, is_production=?, created_at=CURRENT_TIMESTAMP, seat_angle=?, seat_length=?, top_length=?, head_angle=?, wheel_base=?, bb_length=?, wheel_size=?, clearance=? where `id`=?";

// クエリ実行
execDB($pdo, $sql,$data['name'], $data['description'], (int)($data['is_production']), $data['seat_angle'], $data['seat_length'], $data['top_length'], $data['head_angle'], $data['wheel_base'], $data['bb_length'], $data['wheel_size'], $data['clearance'], $data['id']);
echo('success');
