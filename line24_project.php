<!DOCTYPE html>
<html>
<head>
	<title>Line24 - Работа проекта по дням</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link rel="stylesheet" href="style/style.css">
	<link rel="shortcut icon" href="img/favicon.ico" type="image/png">
</head>
<body>
	<?php
		$header_tittle = ' - Работа проекта по дням';
		include('line24_header.php');
	?>

	<?php include('line24_menu.php'); ?>

	<?php
		include('line24_project.class');

		$line_project = new line24_project();

		echo "<form id = 'form2' action = '' method = 'get'>";
			echo "<div class = 'title'>";
				echo "Выберите проект:";
				echo "<span class = 'custom-dropdown'>";
					echo "<select name = 'selected_project'>";
						foreach($line_project->array_project as $key => $value){
							$tmp_check = '';
							if($_GET['selected_project'] == $key){		//	если был пост и выбрали какой-то проект
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
			$project_id = $_GET['selected_project'];

			$line_project->get_selected_csv_project($start_day, $end_day, $project_id);
			$line_project->get_oper_array($line_project->array_csv);
			$line_project->show_project_work($line_project->oper_array);
		}
	?>	
	<?php include('line24_footer.php'); ?>
</body>
</html>