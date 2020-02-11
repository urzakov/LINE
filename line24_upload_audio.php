<!DOCTYPE html>
<html>
<head>
	<title>Line24 - Выгрузка аудио по результатам звонка</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link rel="stylesheet" href="style/style.css">
	<link rel="shortcut icon" href="img/favicon.ico" type="image/png">
</head>
<body>
	<?php
		$header_tittle = ' - Выгрузка аудио по результатам звонка';
		include('line24_header.php');
		include('line24_menu.php');
		include('line24_upload_audio.class');

		$line24_upload_audio = new line24_upload_audio();
		
		echo "<form id = 'form2' action = '' method = 'post'>";
			echo "<div class = 'title'>";
				echo "Выберите проект:";
				echo "<span class = 'custom-dropdown'>";
					echo "<select name = 'selected_project'>";
						foreach($line24_upload_audio->array_project as $key => $value){
							$tmp_check = '';
							if($_POST['selected_project'] == $key){		//	если был пост и выбрали какой-то проект
								$tmp_check = 'selected';
							}
							echo "<option value = '$key' $tmp_check>$value</option>";
						}
					echo "</select>";
				echo "</span>";
				echo "<BR>";
				if(isset($_POST['start_day'])){
					$selected_start_day = $_POST['start_day'];
				} else {
					$selected_start_day = date('Y-m-d', time());
				}
				if(isset($_POST['end_day'])){
					$selected_end_day = $_POST['end_day'];
				} else {
					$selected_end_day = date('Y-m-d', time());
				}
				echo "<p>Начальная дата: <input type = 'date' name = 'start_day' value = '$selected_start_day'>";
				echo "<p>Конечная дата: <input type = 'date' name = 'end_day' value = '$selected_end_day'>";
				echo "<p><input type = 'submit' value = 'Сделать выборку'></p>";
			echo "</div>";
		echo "</form>";
	
		if($_POST){
			echo "<HR>";
			$start_day = $_POST['start_day'];
			$end_day = $_POST['end_day'];
			$project_id = $_POST['selected_project'];
			
			$queue_anketa = $line24_upload_audio->get_anketa($line24_upload_audio->array_project[$project_id]);
			$array_anketa = $line24_upload_audio->get_array_anketa($queue_anketa, $start_day, $end_day);
			
			if(count($array_anketa) > 1){		//	если по выбранному проекту за выбранный день есть анкета
				$array_status = $line24_upload_audio->get_array_status($array_anketa);
				if(!isset($_POST['selected_result'])){	//	если не выбирали еще результаты звонка
					$line24_upload_audio->show_status($array_status);
				} else {	//	если выбрали результаты звонка
					$array_selected_result = $_POST;
					unset($array_selected_result['selected_result']);
					unset($array_selected_result['start_day']);
					unset($array_selected_result['end_day']);
					unset($array_selected_result['selected_project']);
					
					$line24_upload_audio->get_array_anketa_result($array_selected_result, $array_anketa);
					$line24_upload_audio->get_selected_csv_project($start_day, $end_day, $project_id);
					$line24_upload_audio->get_array_audio($start_day, $end_day, $project_id);
					
/*					echo '<pre>';
						var_dump($line24_upload_audio->array_csv);
					echo '</pre>';*/
				}
			} else {
				if($start_day == $end_day){
					$period = " $start_day ";
				} else {
					$period = " период с $start_day по $end_day ";
				}
				echo "<div class = 'title'>";
					echo "<p class = 'title'>За $period по проекту: <span style = 'color:red; font-size: 20pt;'>".$line24_upload_audio->array_project[$project_id]."</span> не обнаружено анкет</p>";
				echo "</div>";
			}


//			$line24_upload_audio->get_selected_csv_project($start_day, $end_day, $project_id);
		}
	
		include('line24_footer.php');
	?>
</body>
</html>