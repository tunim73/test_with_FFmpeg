<?php

require_once 'config.php';

/* 
\"
  [0:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)+50':y='ih/2-(ih/zoom/2)',trim=duration=$imageDuration [v0]; \
  [1:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)':y='ih/2-(ih/zoom/2)-50',trim=duration=$imageDuration [v1]; \
  [2:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)+50':y='ih/2-(ih/zoom/2)',trim=duration=$imageDuration [v2]; \
  [3:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)-50':y='ih/2-(ih/zoom/2)+50',trim=duration=$imageDuration [v3]; \
  [4:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)-100':y='ih/2-(ih/zoom/2)-100', fade=out:st=3:d=1,trim=duration=$imageDuration [v4]; \
  [v0][v1] xfade=transition=slideup:duration=1:offset=4 [t1]; \
  [t1][v2] xfade=transition=slideright:duration=1:offset=8 [t2]; \
  [t2][v3] xfade=transition=slidedown:duration=1:offset=12 [t3]; \
  [t3][v4] xfade=transition=slideleft:duration=1:offset=16[v] \
  \" \
  -pix_fmt yuv420p -c:v libx264 \
-map \"[v]\"  londonComZoomETransacao.mp4 -y";

*/

$zoomConfig = "zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageTime";
$allZoom = "";

$allTransitions = "";

foreach ($files as $index => $file) {

  //organiza inputs de imagens
  $cmd .= "-loop 1 -t 2 -i $file \\";

  //labels de entrada e saída do zoom
  $inputZoom = "[$index:v]";
  $outputZoom = "[v$index]";

  $allZoom .= "$inputZoom$zoomConfig $outputZoom; \\\n";

  //label de entrada e saída da transtion
  $indexMaisUm = $index + 1;

  if ($index === 0) {
    $inputTransition = "[v$index][v$indexMaisUm]";
    $outputTransition = "[t$indexMaisUm];";
  } else if ($index < count($files) - 2) {
    $inputTransition = "[t$index][v$indexMaisUm]";
    $outputTransition = "[t$indexMaisUm];";
  } else if ($index === count($files) - 2) {
    $inputTransition = "[t$index][v$indexMaisUm]";
    $outputTransition = "[out]";
  }
  
  $offset = $imageTime * ($index + 1) - ($index + 1);
  $transitionConfig = "xfade=transition=slideup:duration=$transitionTime:offset=$offset";

  if ($index < count($files) - 1)
    $allTransitions .= "$inputTransition $transitionConfig $outputTransition \\\n";


  // outputs do filtro
 /*  if ($index === count($files) - 1) {
    
  } */

}
$filter_complex .= "$allZoom$allTransitions\" ";
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







