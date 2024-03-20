<?php

/* Variáveis Dinâmicas */

$dynamicDirectory = '/../imgLondon';
$fileName = 'output.mp4';




/* Configurações do vídeo */

$imageTime = 2;
$quality = 'hd720';
$outputFrameRate = 25;
$zoomDuration = $outputFrameRate * $imageTime;

$transitionTime = 0.5;




$codec = "libx264";
$format = "yuv420p";

$finalConfig = "-pix_fmt $format -c:v $codec \-map \"[out]\" $fileName -y";



/* Constantes */

//busca de arquivos
$imageDirectory = dirname(__FILE__) . $dynamicDirectory;
$files = glob($imageDirectory . '/*.jpg');


// comandos estruturais do ffmpeg
$cmd = "ffmpeg \\";
$filter_complex = "-filter_complex \"";



