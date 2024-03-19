<?php

/* Variáveis Dinâmicas */

$dynamicDirectory = '/../imgLondon';
$fileName = 'output.mp4';








/* Constantes */

//busca de arquivos
$imageDirectory = dirname(__FILE__) . $dynamicDirectory;
$files = glob($imageDirectory . '/*.jpg');


// comandos estruturais do ffmpeg
$cmd = "ffmpeg \\";
$filter_complex = "-filter_complex \" ";
$finalConfig = "-map \"[out]\" $fileName -y";


