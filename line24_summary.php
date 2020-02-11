<!DOCTYPE html>
<html>
<head>
	<title>Line24 - Сводный отчет за месяц</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link rel="stylesheet" href="style/style.css">
	<link rel="shortcut icon" href="img/favicon.ico" type="image/png">
</head>
<body>
	<?php
		$header_tittle = ' - Сводный отчет за месяц';
		include('line24_header.php');
		include('line24_menu.php');
		include('line24_summary.class');

		$line_summary = new line24_summary();

		$line_summary->get_month_year();

		echo "<form id = 'form2' action = '' method = 'get'>";
			echo "<div class = 'title'>";

				//	если не было гета то по умолчанию будет текущий месяц и текущий год, если гет был - берем из гета
				$tmp_str1 = $line_summary->current_month;
				if(isset($_GET['selected_month'])) $tmp_str1 = $_GET['selected_month'];
				$tmp_str2 = $line_summary->current_year;
				if(isset($_GET['selected_year'])) $tmp_str2 = $_GET['selected_year'];

				echo "Выберите месяц и год:";
				echo "<span class = 'custom-dropdown'>";
					echo "<select name = 'selected_month'>";
						foreach($line_summary->array_month as $key => $value){
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
						foreach($line_summary->array_year as $key => $value){
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
			echo "<HR>";
			
			$line_summary->selected_month = $_GET['selected_month'];
			$line_summary->selected_year = $_GET['selected_year'];

			$line_summary->get_day_by_month_year($line_summary->selected_month, $line_summary->selected_year);

			$start_day = $line_summary->selected_days['first_day'];
			$end_day = $line_summary->selected_days['last_day'];

			$line_summary->get_active_oper($start_day, $end_day);

			$line_summary->show_summary($start_day, $end_day);

/*			echo '<pre>';
				var_dump($line_summary->time_duration_array);
			echo '</pre>';*/
		}

		include('line24_footer.php');
	?>
</body>
</html>