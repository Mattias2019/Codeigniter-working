<html>
<head>
<title>PHP SmoothCurve</title>
<!-- Load jQuery -->
<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAAJfELtWGd8Z-juC8nz2foOxTjZkfxR82EOc_9H6Jx_Zf94zcxchThzbvJ6_W0tGzFvSbs-uBVr7T1hw"> </script>
<script type="text/javascript">
	google.load("jquery", "1");
</script>
</head>
<body>
<h2>PHP SmoothCurve</h2>
<h3>Демонстрация</h3>
<img src="demo_image.php?pl=1&lp=1&cs=1&as=1&bc=1&type=1&xd=1&aa=1" id="graph"><br/><br/>

Расположение точек
<select id="type">
	<option value="1">с максимумом посередине</option>
	<option value="2">случайное</option>
	<option value="3">возрастание</option>
	<option value="4">синусоида</option>
</select><br/>

Количество точек:
<input type="radio" name="points" id="p5" value="5" /><label for="p5">5</label>
<input type="radio" name="points" id="p15" value="15" checked="checked"/><label for="p15">15</label>
<input type="radio" name="points" id="p50" value="50" /><label for="p50">50</label>
<br/>
<input type="checkbox" id="xd" checked="checked" /><label for="xd">расположить точки равномерно по X</label><br/>
<input type="checkbox" id="aa" checked="checked" /><label for="aa">антиалиасинг</label><br/>
<br/>
Виды интерполяции/апроксимации:<br/>
<input type="checkbox" id="pl" checked="checked" /><label for="pl">кусочно-линейная инт.</label><br/>
<input type="checkbox" id="lp" checked="checked" /><label for="lp">многочлен Лагранжа</label><br/>
<input type="checkbox" id="cs" checked="checked" /><label for="cs">кубический сплайн</label><br/>
<input type="checkbox" id="as" checked="checked" /><label for="as">сплайн Акима</label><br/>
<input type="checkbox" id="bc" checked="checked" /><label for="bc">кривая Безье</label><br/>
<input type="button" id="refresh" value="Обновить"/><br/>

<script language="javascript">
$('#refresh').click(function() {
	$('#graph').attr('src', 'demo_image.php?pl=' + +$('#pl').is(':checked') + '&lp=' + +$('#lp').is(':checked') + '&cs=' + +$('#cs').is(':checked') + '&as=' + +$('#as').is(':checked') + '&bc=' + +$('#bc').is(':checked') + '&xd=' + +$('#xd').is(':checked') + '&aa=' + +$('#aa').is(':checked') + '&type=' + $("#type option:selected").val() + '&pn=' + $('input[name=points]:checked').val() + '&r=' + Math.random());
});
</script>
</body>
</html>

