<?php
//ミッション6-2
//とりあえずメールアドレスのフォームを作る
?>
<html>
<head>
 <title>メールフォーム</title>
</head>

<body>
 <p>
メールを送信します<br>
名前とメールアドレスを入力してください
 </p>
 <p>
<!-- send_test.phpにPOSTします -->
<form action="send_test.php" method="post">
宛先メール:<br>
<input type="TEXT" name="address" placeholder="メールアドレス" ><br>
<br>
名前:<br>
<input type="TEXT" name="name"  Placeholder="名前"><br>
<br>
本文<br>
<textarea name="message01" cols="50" rows="5" placeholder="本文"></textarea>
<br>
<input type="submit" value="送信" />
 </p>

</form>
</body>
</html>