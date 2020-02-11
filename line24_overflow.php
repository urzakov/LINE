<!DOCTYPE html>
<html>
<head>
	<title>Line24 - Звонки в очереди</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link rel="stylesheet" href="style/style.css">
	<link rel="shortcut icon" href="img/favicon.ico" type="image/png">
</head>
<body>
	<?php
/*	===!!! template for debug !!!===

	echo '<pre>';
		var_dump($result3);
	echo '</pre>';

	===!!! template for debug !!!===	*/


		$header_tittle = ' - Звонки в очереди';
		include('line24_header.php');
		include('line24_menu.php');
		
		echo '<pre><b>asterisk -x "queue show 500"</b> :<br /><br />';
		$result = shell_exec('asterisk -x "queue show 500"');
//		echo $result;

		echo '<pre>';
			var_dump($result);
		echo '</pre>';

		$array_result = array();
		$index = 0;
		$tmp_str = '';
		for($i = 0, $str_len = strlen($result); $i < $str_len; $i++){
//			echo $result[$i]."-".ord($result[$i])."<BR>";
			if(ord($result[$i]) == 10 AND ord($result[$i-1]) == 10){
				$array_result[$index] = $tmp_str;
				$tmp_str = '';
				$index++;
			}
			$tmp_str .= $result[$i];
		}
		
		echo '<pre>';
			var_dump($array_result);
		echo '</pre>';

		echo '<br /><hr><br />';

		echo '<b>asterisk -x "queue show"</b> :<br /><br />';
		$result = shell_exec('asterisk -x "queue show"');
//		echo $result . '</pre>';
		
		echo '<pre>';
			var_dump($result);
		echo '</pre>';
		
		$array_result = array();
		$index = 0;
		$tmp_str = '';
		for($i = 0, $str_len = strlen($result); $i < $str_len; $i++){
//			echo $result[$i]."-".ord($result[$i])."<BR>";
			if(ord($result[$i]) == 10 AND ord($result[$i-1]) == 10){	//	если это конец блока по очереди
				
				$array_result[$index] = $tmp_str;
				$tmp_str = '';
				$index++;
			}
			$tmp_str .= $result[$i];
		}
		
		echo '<pre>';
			var_dump($array_result);
		echo '</pre>';
		
		include('line24_footer.php');
	?>
</body>
</html>