<!DOCTYPE html>
<html>
<head>
	<title>Line24</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link rel="stylesheet" href="style/style.css">
	<link rel="shortcut icon" href="img/favicon.ico" type="image/png">
</head>
<body>
	<?php
		$header_tittle = '';
		include('line24_header.php');
		include('line24_menu.php');
		include('line24_monitor.class');
		
		$line_monitor = new line24_monitor();
		
		$line_monitor->get_array_project();
		$line_monitor->get_billings(0);


//		master		
		$line_monitor->get_billings(1);
		$line_monitor->show_monitor();
//		echo "<span class = 'header_tittle'>Домашняя страница. В дальнейшем здесь будет шикарный мониторинг...</span>";
		
		include('line24_footer.php');
	?>
</body>
</html>