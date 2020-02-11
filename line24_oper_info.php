<!DOCTYPE html>
<html>
<head>
	<title>Line24 - Информация по оператору</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link rel="stylesheet" href="style/style.css">
	<link rel="shortcut icon" href="img/favicon.ico" type="image/png">
</head>
<body>
	<?php
		$header_tittle = ' - Информация по оператору';
		include('line24_header.php');
	?>

	<?php include('line24_menu.php'); ?>

	<?php
		include('line24_oper_info.class');

		$line_oper_info = new line24_oper_info();

		echo "<form id = 'form2' action = '' method = 'get'>";
			echo "<div class = 'title'>";
				echo "Выберите оператора:";
				echo "<span class = 'custom-dropdown'>";
					echo "<select name = 'selected_oper'>";
						foreach($line_oper_info->array_oper as $key => $value){
							$tmp_check = '';
							if($_GET['selected_oper'] == $key){		//	если был пост и выбрали какого-то оператора
								$tmp_check = 'selected';
							}
							echo "<option value = '$key' $tmp_check>$value</option>";
						}
					echo "</select>";
				echo "</span>";
				echo "<BR>";
				if(isset($_GET['start_day'])){
					$selected_start_day = $_GET['start_day'];
				} else {
					$selected_start_day = date('Y-m-d', time());
				}
				if(isset($_GET['end_day'])){
					$selected_end_day = $_GET['end_day'];
				} else {
					$selected_end_day = date('Y-m-d', time());
				}
				echo "<p>Начальная дата: <input type = 'date' name = 'start_day' value = '$selected_start_day'>";
				echo "<p>Конечная дата: <input type = 'date' name = 'end_day' value = '$selected_end_day'>";
				echo "<p><input type = 'submit' value = 'Сделать выборку'></p>";
			echo "</div>";
		echo "</form>";
		
		if($_GET){
			$start_day = $_GET['start_day'];
			$end_day = $_GET['end_day'];
			$oper_id = $_GET['selected_oper'];

/*			echo '<pre>';
				var_dump($_GET);
			echo '</pre>';*/

			$array_oper_pauses = $line_oper_info->get_oper_pauses($start_day, $end_day, $oper_id);
			$selected_time = '2020-01-22 10:10:44';
			$flag = $line_oper_info->get_oper_flag_by_time($array_oper_pauses, $selected_time);

			echo '<pre>';
				var_dump($flag);
			echo '</pre>';

		}

		
	?>	
	<?php include('line24_footer.php'); ?>
</body>
</html>