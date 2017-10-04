<?php

//1. GETでidを受信
$id   = $_GET["id"];

//2. DB接続
try {
  $pdo = new PDO('mysql:dbname=gs_db28;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}


//３．SQLを作成(ｓｔｍｌの中で)
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE id= :id");
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
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
  <title>Userデータ更新</title>
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
<form method="post" action="user_update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>User登録</legend>
     <label>ユーザ名：<input type="text" name="name" value="<?=$row["name"]?>"></label><br>
     <label>ユーザID：<input type="text" name="lid" value="<?=$row["lid"]?>"></label><br>
     <label>パスワード：<input type="text" name="lpw" value="<?=$row["lpw"]?>"></label><br>
     <label>管理フラグ：<input type="text" name="kanri_flg" value="<?=$row["kanri_flg"]?>"></label><br>
     <label>生存フラグ：<input type="text" name="life_flg" value="<?=$row["life_flg"]?>"></label><br>
	  <input type="hidden" name ="id" value="<?= $row["id"]?>">
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>