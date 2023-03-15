<?php
require_once('common/functions.php');
require_once('common/routing.php');

// 各種ヘッダーを設定
// header('Content-Type: application/json; charset=UTF-8');
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding, X-Requested-With, Origin, X-Csrftoken, Accept");
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, CONNECT, OPTIONS, TRACE, PATCH, HEAD");

// ルーティング設定を与えてルーティングを実行します。
path_route(array(
    // ルートディレクトリに来た時の動作の例です
    // array(httpのメソッド名, ルートディレクトリからのパス, メソッド)のように指定します。
    array('*', '/', function(){ echo('シンプルなルーティングのテストです。'); }),
    // フォームの表示の例です
    array('GET', '/form/', function(){
        echo '<!DOCTYPE html><html><head><title>test</title></head><body>
            <form method="post"><input type="text" name="name"><input type="submit"></form>
            </body></html>';
    }),
    // POST の例です。
    array('POST', '/form/', function(){ echo(filter_input(INPUT_POST, 'name') . ' が送信されました。'); }),
    // パラメータ付きのURLのルーティングの例です。
    array('GET', '/users/:id', function($params){ echo("ユーザー {$params['id']} さんのページです。"); }),
    // 404 の例です。
    array('*', '404', function(){ echo 'ページが見つかりません。'; })
));

?>