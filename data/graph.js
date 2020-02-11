<canvas id='example'>Обновите браузер</canvas>
<script>
	var example = document.getElementById("example"),
		ctx     = example.getContext('2d');
	example.width  = 1280;
	example.height = 350;
	
	ctx.beginPath();
	ctx.fill(); // *14
	ctx.moveTo(30, 15);
	ctx.lineTo(30, 310);
	ctx.lineTo(1230, 310);
	ctx.stroke();

	let hours = <?php echo $json;?>;

	ctx.fillStyle = "#2980b9";
	ctx.font = "bold 10pt Georgia";
	ctx.fillText("Минуты в час", 1, 10);
	ctx.fillText("Часы", 1235, 315);
	for(var x = 0; x < 24; x++){
		var text = x;
		ctx.fillText(text, 30 + x * 50, 320);
		ctx.strokeRect(35 + x * 50, 310, 45, -hours[x] * 5);
		ctx.fillText(hours[x], 40 + x * 50, 310 - hours[x] * 5 - 5);
	}
</script>