<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>美男美女診断</title>
		<link rel="icon" type="" href="favicon.ico">
		<link rel="apple-touch-icon" href="img/icon.png">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" media="screen" href="css/cyborg.css">
		<link rel="stylesheet" media="screen" href="css/my.css">
	</head>

<body>
	<div class="container">
		<?php
		//環境変数の値を取得
		$key = getenv('REKO_KEY');
		$sec = getenv('REKO_SEC');

		//APIを利用して値を取得
		$ch = curl_init();
		$data = array('api_key' => $key,
									'api_secret' => $sec,
									'jobs' => 'face_part_aggressive_beauty_glass_sex',
									'urls' => $_POST["upfile"]
									);

		curl_setopt($ch, CURLOPT_URL, 'http://rekognition.com/func/api/');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$json = curl_exec($ch);
		curl_close($ch);

		// オブジェクト毎にパース
		// trueを付けると連想配列として分解して格納してくれます。
		$obj = json_decode($json, true);

		// パースに失敗した時は処理終了
		if ($obj === NULL) {
			return;
		}

		// 表示
		// var_dump($obj);

		?>
		<img src="<?php echo $obj["url"]?>" style="max-height: 300px" class="resultpic">
		<?php

		?>
		<h1>あなたの
		<?php

		if ($obj["face_detection"][0]["sex"] == 1) {

		?>
		美男
		<?php

		} else {

		?>
			美女
		<?php

		};
		?>
		指数は...</h1>
		<h1><?php echo $obj["face_detection"][0]["beauty"] * 100 ?>％</h1>
		<?php

		if ($obj["face_detection"][0]["sunglasses"] >= 0.5) {
			?>
			<p>サングラス...素敵ですよ（コソッ</p>
			<?php
		} elseif ($obj["face_detection"][0]["glasses"] == 1) {
			?>
			<p>メガネ...似合ってますよ（ボソッ</p>
			<?php
		}

		if ($obj["face_detection"][0]["beauty"] >= 0.99) {
			?>
			<p>Siri「クラウドでは、誰もがきれいなんですよ。」</p>
			<?php
		}


		?>

		<FORM>
			<INPUT type="button" value="戻る" class="btn btn-primary" onClick="history.back()">
		</FORM>
	</div>
</body>
</html>