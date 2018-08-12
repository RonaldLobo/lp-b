<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
</head>
<body>
    <iframe src="" id='myIframe' width="500" height="600"></iframe>
    <!--file_get_contents('htp://url_of_the_iframe/content.php');-->
    <div class="page">
    </div>
    <input type="number" name="jornada" value="" placeholder="jornada" id='jornada'>
    <input type="button" name="llamar" value="llamar" onclick="llamaResultados();">
    <script>
        function llamaResultados(){
            document.getElementById('myIframe').src = 'http://www.livescore.com/soccer/costa-rica/clasura/#/round-'+ $('#jornada').val();
            setTimeout(obtineResultados, 3000)
        }
        function obtineResultados(){
            var iframeBody = $("#myIframe").contents().find("body");
            console.log(iframeBody);
            var juegos = $('.content div[data-type=container] .row-gray');
            var partidosQuiniela = {};
            partidosQuiniela.juegos = [];
            for(var i = 0; i<juegos.length; i++){
                var partido = {};
                partido.equipo1 = $(juegos[i]).children('.ply.tright.name').children('span').text();
                partido.equipo2 = $(juegos[i]).children('.ply.name').not('.ply.tright.name').children('span').text();
                partido.resultadoEquipo1 = $(juegos[i]).children('.sco').children('.scorelink').children('.hom').text();
                partido.resultadoEquipo2 = $(juegos[i]).children('.sco').children('.scorelink').children('.awy').text();
                if($.isNumeric(partido.resultadoEquipo1) && $.isNumeric(partido.resultadoEquipo2)){
                    partidosQuiniela.juegos.push(partido);
                }
            }
            console.log(partidosQuiniela);
        }
    </script>
</body>
</html>
<?php
echo "test";
function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
echo get_data("http://www.livescore.com/soccer/costa-rica/clasura/#/round-2");
?>

