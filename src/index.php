<?php

require_once 'config.php';

/* 
\"
  [0:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration [v0]; \
  [1:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration [v1]; \
  [2:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration [v2]; \
  [3:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration [v3]; \
  [4:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration, fade=out:st=4:d=1 [v4]; \
  [v0][v1][v2][v3][v4]concat=n=5:v=1:a=0,format=yuv420p[v]\" \
  -pix_fmt yuv420p -c:v libx264 \
-map \"[v]\"  londonComZoom.mp4 -y";

*/

$zoomConfig = "zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageTime";

$concatFilters = "";

foreach ($files as $index => $file) {

  //organiza inputs de imagens
  $cmd .= "-loop 1 -t 2 -i $file \\";

  //labels de entrada e saída
  $inputFilter = "[$index:v]";
  $outputFilter = "[v$index]";

  $filter_complex .= "$inputFilter$zoomConfig $outputFilter; \\\n";

  //[v0][v1][v2][v3][v4]
  $concatFilters .= $outputFilter;

  // outputs do filtro

  if ($index === count($files) - 1) {
    $countFiles = count($files);
    $concat = "concat=n=$countFiles:v=1:a=0,format=$format [out] \" \\";
    $filter_complex .= "$concatFilters $concat";
  }

}

$cmd .= $filter_complex;
$cmd .= $finalConfig;

echo $cmd . "\n \n \n";
exec($cmd);


/* 

ffmpeg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-01.jpg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-02.jpg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-03.jpg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-04.jpg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-05.jpg \-filter_complex " [0][1][2][3][4] concat=n=5 [out] " \-map "[out]" output.mp4 -y



ffmpeg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-01.jpg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-02.jpg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-03.jpg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-04.jpg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-05.jpg \-filter_complex "[0:v]zoompan=z='min(zoom+0.0010,1.5)':d=75:s=hd720,trim=duration=3 [v0]; \
[1:v]zoompan=z='min(zoom+0.0010,1.5)':d=75:s=hd720,trim=duration=3 [v1]; \
[2:v]zoompan=z='min(zoom+0.0010,1.5)':d=75:s=hd720,trim=duration=3 [v2]; \
[3:v]zoompan=z='min(zoom+0.0010,1.5)':d=75:s=hd720,trim=duration=3 [v3]; \
[4:v]zoompan=z='min(zoom+0.0010,1.5)':d=75:s=hd720,trim=duration=3 [v4]; \
[v0][v1][v2][v3][v4] concat=n=5:v=1:a=0,format=yuv420p [out] " \-pix_fmt yuv420p -c:v libx264 \-map "[out]" output.mp4 -y

*/







