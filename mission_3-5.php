<?php
?>
<html>
<head>
<title>mission_3-5</title>
</head>
<body>
<h1>mission_3-5</h1>

適当にコメントを打ち込んで削除したり編集してみてもらえると助かります!<br>
    よろしくお願いします!
<hr>



<?php
//ここから編集
//パスワードが一致したら編集されるようにする	
if(!empty($_POST["edit"])){
$filename = "mission_3-5.txt";
$hairetsu = file($filename);
	foreach($hairetsu as $row){
        $each = explode("<>",$row);
		if($each[0] === $_POST["edit"] && $each[4] === $_POST["edi_pass"]){
		$display_name = $each[1];
		$display_comment =  $each[2];
		$display_num = $each[0];
		$display_pass = $each[4];
		}
 	}
}
//3-4に追加している
//それぞれにパスワードの項目を追加
//名前、コメント、日時、パスワードの順にテキストに保存される
?>

<form method="POST" action="">
	お名前：<input type="text" name="name" 
	value = "<?php if(!empty($display_name)) echo $display_name ?>"><br>
	コメント：<input type="text" name="comment"
	value = "<?php if(!empty($display_comment)) echo $display_comment ?>"><br>
	パスワード：<input type = "password" name="password"
	value = "<?php if(!empty($display_pass)) echo $display_pass ?>"><br>
	<input type ="hidden" name="edit_num" 
	value ="<?php if (!empty($display_num)) echo $display_num ?>">
	
	<input type="submit" name="submit" value="送信"><br>
	
	削除対象番号:<input type="text" name="delete"><br>
	パスワード：<input type = "password" name = "del_pass"><br>
	
	<input type="submit" name="submit2" value="削除"><br>
	
	編集対象番号:<input type="text" name="edit"><br>
	パスワード：<input type = "password" name = "edi_pass"><br>
	
	<input type="submit" name="submit3" value="編集"><br>

<hr>	
</form>

<?php
//ここからは削除
//パスワードが一致したら削除する
	if(!empty($_POST["delete"])){
	$filename = "mission_3-5.txt";
	$array2 = file($filename);//ファイルの中身を配列として入手
	$chosen = $_POST["delete"];
	$fp =fopen($filename,"w");//一旦ファイルの中身を空に
	fwrite($fp,"");
	fclose($fp);
		foreach($array2 as $each2){
		$parts2 = explode("<>", $each2);
			if($parts2[0] === $chosen && $parts2[4] === $_POST["del_pass"]){}
			else{
			$fp =fopen($filename,"a");
			fwrite($fp,$each2);
			fclose($fp);
			echo $parts2[0]." ". $parts2[1]." ". $parts2[2]." ". $parts2[3]." "."<br>";
			}
		}
	}
//新規投稿フォーム
//パスワードを$passとして追加しました
//パスワードの後にもちゃんと<>を入れること
	if(!empty($_POST["name"])||!empty($_POST["comment"])){
	 if(empty($_POST["edit_num"])){
	 $namae = $_POST["name"];
	 $come = $_POST["comment"];
	 $time = date("Y-m-d H:i:s");
	 $pass = $_POST["password"];
	 $filename = "mission_3-5.txt";
		if(!empty($filename)){
		$array1 = file($filename);
		$last_line = end($array1);
		$last_array1 = explode("<>", $last_line);
		$last_num = $last_array1[0];
		$addline = (int)$last_num +1;//変数が数字ということを示す
		} else { $addline = 1;
		}
	 $fp = fopen($filename,"a");
	 fwrite($fp,$addline."<>" .$namae."<>". $come."<>".$time."<>".$pass."<>"."\n");
	 fclose($fp);
	 $array1 = file($filename);
		foreach($array1 as $each){
		$parts = explode("<>",$each);
		echo $parts[0]. $parts[1]. $parts[2]. $parts[3]."<br>";
		}
	 }
	}
//編集番号が送信されたとき
//隠れたedit_numが送信された場合に編集される
//パスワードは表示されてるし、ここでは特に弄ってない
if(!empty($_POST["edit_num"])){
	$filename = "mission_3-5.txt";
	if(!empty($filename)){
	$array3 = file($filename);
	$fp = fopen($filename,"w");
	fwrite($fp,"");
	fclose($fp);
	$namae = $_POST["name"];
	$come = $_POST["comment"];
	$new_pass = $_POST["password"];
		foreach($array3 as $each3){
		$parts3 = explode("<>", $each3);
			if($parts3[0] === $_POST["edit_num"]){
/*			$replacements = array(1 => $namae, 2 => $come,
			3 => date("Y-m-d H:i:s"));
			$edited = array_replace($parts, $replacements);
			$fp = fopen($filename,"a");
			fwrite($fp, $edited);
			fclose($fp);*/
			$parts3[1] = $namae;
			$parts3[2] = $come;
			$parts3[3] = date("Y-m-d H:i:s");
			$parts3[4] = $new_pass;
			$fp = fopen($filename, "a");
			fwrite($fp, $parts3[0]."<>".$parts3[1]."<>".$parts3[2]."<>".$parts3[3]."<>".$parts3[4]."<>"."\n");
			fclose($fp);
			echo $parts3[0]. $parts3[1]. $parts3[2]. $parts3[3]."<br>";
			}else {
			$fp = fopen($filename, "a");
			fwrite($fp, $each3);
			fclose($fp);
			echo $parts3[0]. $parts3[1]. $parts3[2]. $parts3[3]."<br>";
			}
		}
	}
}

?>

