<!DOCTYPE html>
<html>
<head>
	<title>Line24 - Работа оператора за месяц</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link rel="stylesheet" href="style/style.css">
	<link rel="shortcut icon" href="img/favicon.ico" type="image/png">
</head>
<body>
	<?php
		$header_tittle = ' - Работа оператора за месяц';
		include('line24_header.php');
	?>

	<?php include('line24_menu.php'); ?>

	<?php
		include('line24_oper.class');

		$line_oper_month = new line24_oper();

		$line_oper_month->get_month_year();

		echo "<form id = 'form2' action = '' method = 'get'>";
			echo "<div class = 'title'>";
				echo "Выберите оператора:";
				echo "<span class = 'custom-dropdown'>";
					echo "<select name = 'selected_oper'>";
						foreach($line_oper_month->array_oper as $key => $value){
							$tmp_check = '';
							if($_GET['selected_oper'] == $key){		//	если был гет и выбрали какого-то оператора
								$tmp_check = 'selected';
							}
							echo "<option value = '$key' $tmp_check>$value</option>";
						}
					echo "</select>";
				echo "</span>";
				echo "<BR>";

				//	если не было гета то по умолчанию будет текущий месяц и текущий год, если гет был - берем из гета
				$tmp_str1 = $line_oper_month->current_month;
				if(isset($_GET['selected_month'])) $tmp_str1 = $_GET['selected_month'];
				$tmp_str2 = $line_oper_month->current_year;
				if(isset($_GET['selected_year'])) $tmp_str2 = $_GET['selected_year'];

				echo "Выберите месяц и год:";
				echo "<span class = 'custom-dropdown'>";
					echo "<select name = 'selected_month'>";
						foreach($line_oper_month->array_month as $key => $value){
							$tmp_check = '';
							if($_GET['selected_month'] == $key || $tmp_str1 == $key){		//	если был гет и выбрали какой-то месяц
								$tmp_check = 'selected';
							}
							echo "<option value = '$key' $tmp_check>$value</option>";
						}
					echo "</select>";
				echo "</span>";
				echo "<span class = 'custom-dropdown'>";
					echo "<select name = 'selected_year'>";
						foreach($line_oper_month->array_year as $key => $value){
							$tmp_check = '';
							if($_GET['selected_year'] == $key || $tmp_str2 == $key){		//	если был гет и выбрали какой-то месяц
								$tmp_check = 'selected';
							}
							echo "<option value = '$key' $tmp_check>$value</option>";
						}
					echo "</select>";
				echo "</span>";
				echo "<BR>";
				echo "<p><input type = 'submit' value = 'Сделать выборку'></p>";
			echo "</div>";
		echo "</form>";

		if($_GET){
			$line_oper_month->selected_month = $_GET['selected_month'];
			$line_oper_month->selected_year = $_GET['selected_year'];
			$line_oper_month->selected_oper = $_GET['selected_oper'];

			$line_oper_month->get_day_by_month_year($line_oper_month->selected_month, $line_oper_month->selected_year);

			$line_oper_month->get_selected_csv_oper($line_oper_month->selected_days['first_day'], $line_oper_month->selected_days['last_day'], $line_oper_month->selected_oper);
			$line_oper_month->get_time_in_line($line_oper_month->selected_days['first_day'], $line_oper_month->selected_days['last_day'], $line_oper_month->selected_oper);
			$line_oper_month->get_project_array($line_oper_month->array_csv);
			$line_oper_month->show_oper_work_month($line_oper_month->project_array);
		}
	?>	
	<?php include('line24_footer.php'); ?>
</body>
</html>