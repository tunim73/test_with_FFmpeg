<?php

$imageDuration = 2;
$quality = 'hd720';
$zoomDuration = 30 * $imageDuration;

$cmd = "ffmpeg \
-loop 1 -t 1 -i ./imgLondon/london-01.jpg \
-loop 1 -t 1 -i ./imgLondon/london-02.jpg \
-loop 1 -t 1 -i ./imgLondon/london-03.jpg \
-loop 1 -t 1 -i ./imgLondon/london-04.jpg \
-loop 1 -t 1 -i ./imgLondon/london-05.jpg \\";

$filter_complex = "-filter_complex \"";
$filter_complex .= "[0:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration [v0]; \\
";
$filter_complex .= "[1:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration [v1]; \\\n";
$filter_complex .= "[2:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration [v2]; \\
";
$filter_complex .= "[3:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration [v3]; \\\n";
$filter_complex .= "[4:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration, fade=out:st=4:d=1 [v4]; \\\n";
$filter_complex .= "[v0][v1][v2][v3][v4]concat=n=5:v=1:a=0,format=yuv420p[v]\" \\";
$configFinal = "-pix_fmt yuv420p -c:v libx264 \
-map \"[v]\"  londonComZoom.mp4 -y";

$filter_complex .= $configFinal;
$cmd .= $filter_complex;

exec($cmd);


/* 
  comando tem que ficar encostado do \, e, assim deverá utilizar o contra-barra original em string \\
  evitar de utilizar enter e/ou \n \t, mas pelo visto só no comando principal do ffmpeg

  $cmd = "ffmpeg \\";
  $cmd .= "-loop 1 -t 2 -i ./imgLondon/london-01.jpg \\";
  $cmd .= "-loop 1 -t 2 -i ./imgLondon/london-02.jpg \\";
  $cmd .= "-loop 1 -t 2 -i ./imgLondon/london-03.jpg \\";
  $cmd .= "-loop 1 -t 2 -i ./imgLondon/london-04.jpg \\";
  $cmd .= "-loop 1 -t 2 -i ./imgLondon/london-05.jpg \\";

  $filter_complex = "-filter_complex";
  $filter_complex .= " \"[0][1][2][3][4] concat=n=5 [out]\" \\";
  $cmd .= $filter_complex;
  $cmd .= "-map \"[out]\" output.mp4 -y"; 
*/


/* 
Ao usar filter_complex, entre a saída do filtro e o novo filtro, precisa do \\, pois não pode haver espaço, porém obrigatóriamente deve ter um 'enter' ou \n, \t não.


$imageDuration = 2;
$quality = 'hd720';
$zoomDuration = 30 * $imageDuration;

$cmd = "ffmpeg \
-loop 1 -t 1 -i ./imgLondon/london-01.jpg \
-loop 1 -t 1 -i ./imgLondon/london-02.jpg \
-loop 1 -t 1 -i ./imgLondon/london-03.jpg \
-loop 1 -t 1 -i ./imgLondon/london-04.jpg \
-loop 1 -t 1 -i ./imgLondon/london-05.jpg \\";

$filter_complex = "-filter_complex \"";
$filter_complex .= "[0:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration [v0]; \\
";
$filter_complex .= "[1:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration [v1]; \\\n";
$filter_complex .= "[2:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration [v2]; \\
";
$filter_complex .= "[3:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration [v3]; \\\n";
$filter_complex .= "[4:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration, fade=out:st=4:d=1 [v4]; \\\n";
$filter_complex .= "[v0][v1][v2][v3][v4]concat=n=5:v=1:a=0,format=yuv420p[v]\" \\";
$configFinal = "-pix_fmt yuv420p -c:v libx264 \
-map \"[v]\"  londonComZoom.mp4 -y";

$filter_complex .= $configFinal;
$cmd .= $filter_complex;


*/














/* 
  DEU CERTO COM IMAGEM

  $cmd = "ffmpeg -loop 1 -i ./imgLondon/london-01.jpg -t 8 -vf \"zoompan=z='min(zoom+0.0015,1.5)':d=125\"  -c:v libx264 -s '800x450'  animacaoImagem.mp4 -y";

  $cmd = "ffmpeg ";

  $cmd .= " -loop 1 -i ./imgLondon/london-01.jpg -t 5";

  $vf = " -vf ";

  $vf .= "\"zoompan=z='min(zoom+0.0015,1.5)':d=125\"";

  $cmd .= $vf;

  $cmd .= " -c:v libx264 -s '800x450'  animacaoImagem.mp4 -y";

*/