<?php

require_once 'config.php';


$zoomConfig = "zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageTime";

$allZoom = "";
$allTransitions = "";

//input de images + filter_compex de zoom e transitions
foreach ($files as $index => $file) {

  //organiza inputs de imagens
  $cmd .= "-loop 1 -t 2 -i $file \\";

  //labels de entrada e saída do zoom
  $inputZoom = "[$index:v]";
  $outputZoom = "[v$index]";

  if ($index === count($files) - 1) {
    $stFadeOut = $imageTime - 2;
    $allZoom .= "$inputZoom$zoomConfig,fade=out:st=$stFadeOut:d=1 $outputZoom; \\\n";
  } else {
    $allZoom .= "$inputZoom$zoomConfig $outputZoom; \\\n";
  }

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

$cmd .= "-i $audioDirectory \\";
$filter_complex .= "$allZoom$allTransitions\" ";

$positionInputAudio = count($files); // dessa forma o posicionamento do aúdio sempre irá vir após as imagens

$afadeAudio = "-af \"afade=t=out:st=$stAfade:d=$durationAfade\" \\";
$finalConfig = "$afadeAudio-pix_fmt $format -c:v $codec \-map \"[out]\" -map $positionInputAudio -shortest $fileName -y";

$cmd .= $filter_complex;
$cmd .= $finalConfig;

echo $cmd . "\n \n \n";
exec($cmd);


/* 
ffmpeg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-01.jpg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-02.jpg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-03.jpg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-04.jpg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-05.jpg \-i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../audio/audio1.mp3 \-filter_complex "[0:v]zoompan=z='min(zoom+0.0010,1.5)':d=125:s=hd720,trim=duration=6 [v0]; \
[1:v]zoompan=z='min(zoom+0.0010,1.5)':d=125:s=hd720,trim=duration=6 [v1]; \
[2:v]zoompan=z='min(zoom+0.0010,1.5)':d=125:s=hd720,trim=duration=6 [v2]; \
[3:v]zoompan=z='min(zoom+0.0010,1.5)':d=125:s=hd720,trim=duration=6 [v3]; \
[4:v]zoompan=z='min(zoom+0.0010,1.5)':d=125:s=hd720,trim=duration=6,fade=out:st=4:d=1 [v4]; \
[v0][v1] xfade=transition=slideup:duration=0.5:offset=5 [t1]; \
[t1][v2] xfade=transition=slideup:duration=0.5:offset=10 [t2]; \
[t2][v3] xfade=transition=slideup:duration=0.5:offset=15 [t3]; \
[t3][v4] xfade=transition=slideup:duration=0.5:offset=20 [out] \
" -af "afade=t=out:st=21:d=4" \-pix_fmt yuv420p -c:v libx264 \-map "[out]" -map 5 -shortest output.mp4 -y


*/







