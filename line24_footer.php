<HR>
<?php
	$exe_end = time();
	$exe_all = $exe_end - $exe_start;
	if ($exe_all) echo "Время работы программы в секундах: ", $exe_all, " сек";
	$start_year = '2019';
	$cur_year = date('Y', time());

	if($start_year == $cur_year){
		$copyright_year = $start_year;
	} else {
		$copyright_year = $start_year.' - '.$cur_year;
	}
	echo "<p class='copyright'>&#169; $copyright_year WellTell by Urza :: v1.0</p>";
?>