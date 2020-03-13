<!DOCTYPE html>
<html>
<head>
	<title>Line24 - Работа оператора по дням!</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link rel="stylesheet" href="style/style.css">
	<link rel="shortcut icon" href="img/favicon.ico" type="image/png">
</head>
<body>
	<?php
		$header_tittle = ' - Работа оператора по дням';
		include('line24_header.php');
	?>

	<?php include('line24_menu.php'); ?>

	<?php
		include('line24_oper.class');

		$line_oper = new line24_oper();

		echo "<form id = 'form2' action = '' method = 'get'>";
			echo "<div class = 'title'>";
				echo "Выберите оператора:";
				echo "<span class = 'custom-dropdown'>";
					echo "<select name = 'selected_oper'>";
						foreach($line_oper->array_oper as $key => $value){
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

//			$array_csv_in_line = $line_oper->get_time_in_line($start_day, $end_day, $oper_id);

/*			echo '<pre>';
				var_dump($array_csv_in_line);
			echo '</pre>';*/

			$line_oper->get_selected_csv_oper($start_day, $end_day, $oper_id);
			$line_oper->get_time_in_line($start_day, $end_day, $oper_id);
			$line_oper->get_project_array($line_oper->array_csv);
			$line_oper->show_oper_work($line_oper->project_array);
		}
	?>	
	<?php include('line24_footer.php'); ?>
</body>
</html>