<?php


//2. DB接続
try {
  $pdo = new PDO('mysql:dbname=gs_db28;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}


//３．SQLを作成(ｓｔｍｌの中で)
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table ORDER BY book_id ASC");
$status = $stmt->execute();
//実行後、エラーだったらfalseが返る


//４．エラー表示
$view ='';

if($status==false){
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);//エラー表示
  
}else{//正常
	while($r = $stmt->fetch(PDO::FETCH_ASSOC)){
		$view .= '<p>';
		$view .= '<a href ="bm_update_view.php?book_id='.$r["book_id"].'">';//id取得＋リンク先urlにid表示
		$view .= $r["create_date"]."　".$r["book_name"];
		$view .= '</a>';
		$view .= '　';
		$view .= '<a href ="bm_delete.php?book_id='.$r["book_id"].'">';
		$view .= '[削除]';
		$view .= '</a>';
		$view .= '</p>';
	}
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>boolmark表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">boolmark登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
