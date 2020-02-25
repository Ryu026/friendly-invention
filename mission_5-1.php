<?php
//とりあえずデータベースと接続
$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

?>

<?php
//編集番号が投稿された場合
//パスワードが一致したら表示する
if(!empty($_POST["edit"])){
$sql = 'SELECT * FROM thread_1'; //thread_1からの選択
	$stmt = $pdo->query($sql); //$stmtに取得
	$results = $stmt->fetchAll(); //fetchAllでそれを$resultsに
	foreach ($results as $row){
		if($_POST["edit"] === $row['id'] 
		&& $_POST["edi_pass"] === $row['pass']){
		$display_name = $row['name'];
		$display_comment = $row['comment'];
		$display_num = $row['id'];
		$display_pass = $row['pass'];
		}
	}
/*$sql = 'SELECT * FROM thread_1'; //thread_1からの選択
	$stmt = $pdo->query($sql); //$stmtに取得
	$results = $stmt->fetchAll(); //fetchAllでそれを$resultsに
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['time'].'<br>';
	echo "<hr>";
	}
*/
}


?>
<html>
 <head>
  <title>mission_5-1</title>
 <style>
 p {
	color: #666666;
	width: 80%;
	}
 </style>
 </head>
 <body>
 <h1>掲示板</h1>
   <p>気軽にコメントお願いします！</p>

<form method="POST" action="">

<!-- 以下投稿フォーム内の name, comment, password -->
 <fieldset>	
	<legend>投稿フォーム</legend>
 <p>
	お名前：<br>
	<input type="text" name="name" placeholder="山田太郎"
	value = "<?php if(!empty($display_name)) echo $display_name ?>"><br>
	コメント：<br>
	<input type="text" name="comment" placeholder="Hello World"
	value = "<?php if(!empty($display_comment)) echo $display_comment ?>"><br>
	パスワード：<br>
	<input type = "password" name="password" placeholder="password"
	value = "<?php if(!empty($display_pass)) echo $display_pass ?>"><br>
<!-- hiddenで入力された edit_num -->	
	<input type ="hidden" name="edit_num" 
	value ="<?php if (!empty($display_num)) echo $display_num ?>">	
	<input type="submit" name="submit" value="送信"><br>
 </p>
 </fieldset>
<!-- 以下投稿フォーム内の delete, del_pass -->	
 <fieldset>
	<legend>削除フォーム</legend>
 <p>
	削除対象番号:<br>
	<input type="number" name="delete" placeholder = "26"><br>
	パスワード：<br>
	<input type = "password" name = "del_pass" placeholder ="password"><br>
	<input type="submit" name="submit2" value="削除"><br>
 </p>
 </fieldset>
<!-- 以下投稿フォーム内の edit, edi_pass -->	
 <fieldset>
	<legend>編集フォーム</legend>
 <p>
	編集対象番号:<br>
	<input type="number" name="edit" placeholder ="26"><br>
	パスワード：<br>
	<input type = "password" name = "edi_pass" placeholder ="password"><br>
	<input type="submit" name="submit3" value="編集"><br>
</p>
 </fieldset>
<hr>	
</form>
 </body>
</html>

<?php
//とりあえず送信されたデータをデータベースに送る
//テーブル名:thread_1
//id name comment time pass の順に列がある

//新規投稿フォーム
//edit_numが空なら新規扱い
if(!empty($_POST["name"])||!empty($_POST["comment"])){
 if(empty($_POST["edit_num"])){
 $sql = $pdo -> prepare("INSERT INTO thread_1 (name, comment, time, pass) VALUES (:name, :comment, :time, :pass)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':time' , $time, PDO::PARAM_STR);
	$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
	$name = $_POST["name"];//フォームからの名前
	$comment = $_POST["comment"]; //フォームからのコメント
	$time = date("Y-m-d H:i:s"); //フォームでの日時取得
	$pass = $_POST["password"];//フォームからのパスワード
	$sql -> execute();

 $sql = 'SELECT * FROM thread_1'; //thread_1からの選択
	$stmt = $pdo->query($sql); //$stmtに取得
	$results = $stmt->fetchAll(); //fetchAllでそれを$resultsに
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['time'].'<br>';
	echo "<hr>";
	}
 }
}

//新規投稿ではない方
//もうパス確認してるからそのままアップデート
if(!empty($_POST["edit_num"])){
 	//変数の準備
	$id = $_POST["edit_num"]; //投稿番号
	$name = $_POST["name"];//名前
	$comment = $_POST["comment"]; //コメント
	$time = date( "Y-m-d H:i:s"); //日時
	$pass = $_POST["password"]; //パスワード

	$sql = 'update thread_1 set name=:name,comment=:comment,time=:time,pass=:pass where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':time', $time, PDO::PARAM_STR);
	$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();

	$sql = 'SELECT * FROM thread_1'; //thread_1からの選択
	$stmt = $pdo->query($sql); //$stmtに取得
	$results = $stmt->fetchAll(); //fetchAllでそれを$resultsに
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['time'].'<br>';
	echo "<hr>";
	}
}

//削除フォームから投稿された場合
//del_passが一致したら削除
if(!empty($_POST["delete"])){
	$sql = 'SELECT * FROM thread_1'; //thread_1からの選択
	$stmt = $pdo->query($sql); //$stmtに取得
	$results = $stmt->fetchAll(); //fetchAllでそれを$resultsに
	foreach ($results as $row){
		if($_POST["delete"] === $row['id']
		&& $_POST["del_pass"] === $row['pass']){
		$id = $_POST["delete"];
		$sql = 'delete from thread_1 where id=:id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		}
	}

	$sql = 'SELECT * FROM thread_1'; //thread_1からの選択
	$stmt = $pdo->query($sql); //$stmtに取得
	$results = $stmt->fetchAll(); //fetchAllでそれを$resultsに
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['time'].'<br>';
	echo "<hr>";
	}
}

?>	
