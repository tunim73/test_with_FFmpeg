<?php


$cmd = "ffmpeg \\";


for ($i = 1; $i <= 5; $i++) {
  $cmd .= "-loop 1 -t 2 -i ./imgLondon/london-0$i.jpg \\";

}


$filter_complex = "-filter_complex";
$filter_complex .= " \"[0][1][2][3][4] concat=n=5 [out]\" \\";
$cmd .= $filter_complex;
$cmd .= "-map \"[out]\" output.mp4 -y";


$r = exec($cmd);


/* 
  comando tem que ficar encostado do \, e, assim deverá utilizar o contra-barra original em string \\
  evitar de utilizar enter e/ou \n \t

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
  DEU CERTO COM IMAGEM

  $cmd = "ffmpeg -loop 1 -i ./imgLondon/london-01.jpg -t 8 -vf \"zoompan=z='min(zoom+0.0015,1.5)':d=125\"  -c:v libx264 -s '800x450'  animacaoImagem.mp4 -y";

  $cmd = "ffmpeg ";

  $cmd .= " -loop 1 -i ./imgLondon/london-01.jpg -t 5";

  $vf = " -vf ";

  $vf .= "\"zoompan=z='min(zoom+0.0015,1.5)':d=125\"";

  $cmd .= $vf;

  $cmd .= " -c:v libx264 -s '800x450'  animacaoImagem.mp4 -y";

*/