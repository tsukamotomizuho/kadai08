<?php

//1. GETでidを受信
$book_id   = $_GET["book_id"];

//2. DB接続
try {
  $pdo = new PDO('mysql:dbname=gs_db28;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}


//３．SQLを作成(ｓｔｍｌの中で)
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE book_id= :book_id");
$stmt->bindValue(':book_id',$book_id, PDO::PARAM_INT);
$status = $stmt->execute();
//実行後、エラーだったらfalseが返る


//４．エラー表示
$row ='';

if($status==false){
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);//エラー表示
  
}else{//正常
	//1データのみの場合はループさせない
	$row = $stmt->fetch();
	//$row["name"],$row["id"]....

}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
<!--    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>-->
    </div>
  </nav>
</header>
<!-- Head[End] -->


<!-- Main[Start] -->
<form method="post" action="bm_update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>bookmark更新</legend>
     <label>書籍名：<input type="text" name="book_name" value="<?=$row["book_name"]?>" required></label><br>
     <label>書籍URL：<input type="text" name="book_url" value="<?=$row["book_url"]?>" required></label><br>
     <label>書籍コメント：<textArea name="book_comment" rows="4" cols="40"><?=$row["book_comment"]?></textArea></label><br>
	  <input type="hidden" name ="book_id" value="<?= $row["book_id"]?>">
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>