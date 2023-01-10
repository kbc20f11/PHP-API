<?php
require_once('common/config.php');
require_once('common/database.php');

header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding, X-Requested-With, Origin, X-Csrftoken, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, CONNECT, OPTIONS, TRACE, PATCH, HEAD");

// 文字コード対策
mb_language("uni");
mb_internal_encoding("utf-8"); 
mb_http_input("auto");
mb_http_output("utf-8");

// データベースに接続
$pdo = openDB();

// idをクエリから取得
$id = filter_input(INPUT_GET, 'id');

// sql問い合わせ
$sql = "select * from bicycles where `id` = ? and deleted_at is null";
$row = queryDB($pdo, $sql, $id)[0];

// 結果を配列に積め込む
$jsonData=array(
    'id'=>(int)$row['id'],
    'name'=>$row['name'],
    'description'=>$row['description'],
    'is_production'=>boolval($row['is_production']),
    'created_at'=>$row['created_at'],
    'deleted_at'=>$row['deleted_at'],
    'seat_angle'=>$row['seat_angle'],
    'seat_length'=>$row['seat_length'],
    'top_length'=>$row['top_length'],
    'head_angle'=>$row['head_angle'],
    'wheel_base'=>$row['wheel_base'],
    'bb_length'=>$row['bb_length'],
    'wheel_size'=>$row['wheel_size'],
    'clearance'=>$row['clearance']
);


//jsonとして出力
echo json_encode($jsonData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

