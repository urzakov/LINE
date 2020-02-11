<!DOCTYPE html>
<html>
<head>
	<title>Line24 - Статистика</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link rel="stylesheet" href="style/style.css">
	<link rel="shortcut icon" href="img/favicon.ico" type="image/png">
	<script src="data/clipboard.min.js"></script>
	<script type="text/javascript">
		//после загрузки страницы
		window.addEventListener('load', function () {
        // получить коллекцию элементов pre на странице
        var pre = document.getElementsByTagName('pre');
        // перебрать все элементы pre с помощью цикла for
        for (var i = 0; i < pre.length; i++) {
            // создать контейнер div
            var divClipboard = document.createElement('div');
            // добавить к контейнеру div класс .bd-clipboard
            divClipboard.className = 'bd-clipboard';
            // создать элемент span (кнопку Копировать)
            var button = document.createElement('span');
            // добавить к элементу span класс .btn-clipboard
            button.className = 'btn-clipboard';
            // элементу span установить контент Копировать
            button.textContent = 'Копировать';
            // добавить элемент span в качестве дочернего к элементу div
            divClipboard.appendChild(button);
            // добавить элемент div перед pre
            pre[i].parentElement.insertBefore(divClipboard, pre[i]);
        }
        // инициализируем Clipboard для каждой кнопки
        var btnClipboard = new Clipboard('.btn-clipboard', {
            target: function (trigger) {
                console.log(trigger.parentElement.nextElementSibling);
                trigger.clearSelection;
                return trigger.parentElement.nextElementSibling;
            }
        });
        btnClipboard.on('success', function (e) {
 //           e.clearSelection(); //	После нажатия на кнопку убирает выделенное в буфер
        });
		});
	</script>
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!-- ^^^ поддержка тегов Html5 в браузере Internet Explorer ниже 9-й версии -->
</head>
<body>
	<?php
		$header_tittle = ' - Статистика';
		include('line24_header.php');
		include('line24_menu.php'); 
		include('line24_statistics.class');
		
		echo "<form id = 'form1' action = '' method = 'post'>";
		
			$line24_statistic = new line24_statistic();

			$queues = $line24_statistic->array_project;
		
			echo "Выберите очереди:";
			echo "<BR>";

			echo "<div class='column'>";
				foreach($queues as $key => $value){
					echo "<input type = 'checkbox' name = '$key' value = '$value' checked>$value<BR>";
				}
			echo "</div>";
			echo "<BR>";
			echo "<HR>";
		
			//	получаем дату вчерашнего дня
			$day_yesterday = date('Y-m-d', time() - 86400);
		
			//	если не было поста то по умолчанию будет вчерашняя дата, если пост был - дата из поста
			$tmp_str1 = $day_yesterday;
			if(isset($_POST['selected_day_start'])) $tmp_str1 = $_POST['selected_day_start'];
			$tmp_str2 = $day_yesterday;
			if(isset($_POST['selected_day_end'])) $tmp_str2 = $_POST['selected_day_end'];

			echo "Выберите начальную дату: <input style='margin:5px;' type = 'date' name='selected_day_start' value = '$tmp_str1'>";
			echo "<BR>";
			echo "Выберите конечную дату: <input style='margin:5px;' type = 'date' name='selected_day_end' value = '$tmp_str2'>";
			echo "<BR>";
			echo "Выберите часовой пояс проекта:";
			echo "<select name = 'UTC'>";
			$tmp_str = '';
			foreach($line24_statistic->array_UTC as $key => $value){
				if($key == $line24_statistic->project_UTC) $tmp_str = 'selected';
				echo "<option $tmp_str value = $key>UTC +$key ($value)</option>";
			}
			echo "</select>";
			echo "<BR>";
			echo "<input style='margin:5px;' type='submit' value='Показать результаты'><BR>";
		echo "</form>";
		
		echo "<form id = 'form'>";
			echo "<input type = 'checkbox'>Снять/выбрать все очереди";
		echo "</form>";
		
		if($_POST){
			echo "<HR>";
			$array_selected_queue = $_POST;
			unset($array_selected_queue['selected_day_start']);
			unset($array_selected_queue['selected_day_end']);
			unset($array_selected_queue['UTC']);
			
			$line24_statistic->selected_UTC = $_POST['UTC'];

			$tmp_array = $line24_statistic->get_array_days($_POST['selected_day_start'], $_POST['selected_day_end']);

			echo "Ожидайте сообщение, пока отчет сформируется...";
			echo "<details>";
			foreach($array_selected_queue as $key1 => $value1){
				foreach($tmp_array as $key => $value){
					$line24_statistic->get_array_csv($key1, $key);
					$line24_statistic->get_report($line24_statistic->array_csv);
					
					echo "<pre>";
						echo "<table border = 1>";
						echo "<tr>";
						echo "<td>";
							echo "<span style = 'font-family: Calibri'>".$key."</span>";
						echo "</td>";
						echo "<td>";
							echo "<span style = 'font-family: Calibri'>".$line24_statistic->array_to_report[$key1]."</span>";
						echo "</td>";
						foreach($line24_statistic->report as $key2 => $value2){
							echo "<td>";
								echo "<span style = 'font-family: Calibri'>".$value2."</span>";
							echo "</td>";
						}
						echo "</tr>";
						echo "</table>";
					echo "</pre>";
				}
			}
			echo "</details>";
			
			echo "<span style = 'color:red'>Отчет готов</span> (нажмите \"Подробнее\")";
		}

		include('line24_footer.php');
	?>
</body>
<script>
/*	Реализация чекбокса "Выбрать все очереди"	*/
	var _form = form.querySelectorAll('input');
	var _form1 = form1.querySelectorAll('input');

	for(var i=0; i<_form.length; i++){
		_form[i].addEventListener('change', function(e){
			for(var j=0; j<_form1.length; j++){
				if(e.target.getAttribute('class') == _form1[j].getAttribute('class'))
				{
					_form1[j].checked = (!_form1[j].checked) ? true : false;
				}
			}
		})
	}
</script>
</html>