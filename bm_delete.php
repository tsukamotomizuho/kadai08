<?php

//1. POST受信
$book_id     = $_GET["book_id"];


//2. DB接続
try {
  $pdo = new PDO('mysql:dbname=gs_db28;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}
//xampはid:root,passは空


//３．SQLを作成(ｓｔｍｌの中で)
$stmt = $pdo->prepare('DELETE FROM gs_bm_table  WHERE book_id= :book_id');
$stmt->bindValue(':book_id', $book_id, PDO::PARAM_INT);
$status = $stmt->execute();

//４．エラー表示
if($status==false){
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);//エラー表示
  
}else{//処理が終われば『index.php』に戻る。
  header("Location: select.php");//スペース必須
  exit;//おまじない

}
?>
