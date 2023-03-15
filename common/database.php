<?php
//データベース接続処理
function openDB(){
    $pdo = null;

    // https://qiita.com/deigo/items/bb711f1b91f458681c05
    // 定数を展開するラムダ
    $_ = function($s){return $s;};

    // データベース接続情報取得
    $dsn="mysql:dbname={$_(DB_NAME)};host={$_(DB_HOST)};charset=utf8";
    $user= DB_USER;
    $password= DB_PASS;

    try{
        $pdo = new PDO($dsn,$user,$password);
        if($pdo) {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    } catch (Exception $e){
        var_dump($e->getMessage());
        exit(1);
    }
    return $pdo;
}

//データベース操作処理
function execDB($pdo,$sql,...$params){
    try{
        if($pdo === null)
            return false;
        if($params !== null && count($params)){
            $stmt = $pdo->prepare($sql);
            foreach($params as $index => $param){
                $type = gettype($param);
                if(is_int($param))
                    $stmt->bindValue($index+1,$param,PDO::PARAM_INT);
                elseif($type == "resource")
                    $stmt->bindValue($index+1,$param,PDO::PARAM_LOB);
                else
                    $stmt->bindValue($index+1,$param,PDO::PARAM_STR);
            }
            $stmt->execute();
            return $stmt->rowCount();
        }
        return $pdo->exec($sql);
    } catch (PDOException $pdoex){
        var_dump($pdoex->getMessage());
        exit(1);
    }
    return null;
}

//クエリー結果取得処理
function queryDB($pdo,$sql,...$params){
    try{
        if($pdo === null)
            return false;
        $stmt = $pdo->prepare($sql);
        if($params !== null){
            foreach($params as $index => $param){
                $type = gettype($param);
                if(is_int($param))
                    $stmt->bindValue($index+1,$param,PDO::PARAM_INT);
                elseif($type == "resource")
                    $stmt->bindValue($index+1,$param,PDO::PARAM_LOB);
                else
                    $stmt->bindValue($index+1,$param,PDO::PARAM_STR);
            }
        }
        $stmt->execute();
        $results = [];
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
            $results[] = $result;
        }
        return $results;
    }catch(PDOException $pdoex) {
        var_dump($pdoex->getMessage());
        exit(1);
    }
    return null;
}