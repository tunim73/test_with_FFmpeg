<?php

/* Variáveis Dinâmicas */

$dynamicDirectory = '/../imgLondon';
$fileName = 'output.mp4';


/* Constantes */

//busca de arquivos
$imageDirectory = dirname(__FILE__) . $dynamicDirectory;
$files = glob($imageDirectory . '/*.jpg');

$audioDirectory = dirname(__FILE__) . "/../audio/audio1.mp3";

// comandos estruturais do ffmpeg
$cmd = "ffmpeg \\";
$filter_complex = "-filter_complex \"";
// configurações 
$codec = "libx264";
$format = "yuv420p";
$quality = 'hd720';



/* Configurações dinâmicas */

$imageTime = 2; //tempo escolhido para cada imagem

$videoTime = $imageTime * count($files) + 1;

$durationAfade = $imageTime - 1;
$stAfade = $videoTime - $durationAfade - 1;

$outputFrameRate = 25;
$zoomDuration = $outputFrameRate * $imageTime;

$transitionTime = 0.5;

/* não retirar, isso corrige a questão do tempo de cada imagem, visto que elas são limitadas pelo offset em um segundo a menos */
$imageTime++;