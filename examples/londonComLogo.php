<?php

$imageDuration = 5; // tempo de cada imagem
$quality = 'hd720';
$zoomDuration = 30 * $imageDuration; //30 frames (é hd720) por segundo, durante $imageDuration segundos 

$cmd = "ffmpeg \
-loop 1 -t 1 -i ./imgLondon/london-01.jpg \
-loop 1 -t 1 -i ./imgLondon/london-02.jpg \
-loop 1 -t 1 -i ./imgLondon/london-03.jpg \
-loop 1 -t 1 -i ./imgLondon/london-04.jpg \
-loop 1 -t 1 -i ./imgLondon/london-05.jpg \
-i ./audio/audio1.mp3 \
-i ./images3/logo.jpg \
-filter_complex \"
                  [0:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)+100':y='ih/2-(ih/zoom/2)',trim=duration=$imageDuration [v0]; \
                  [1:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)+100':y='ih/2-(ih/zoom/2)',trim=duration=$imageDuration [v1]; \
                  [2:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)+100':y='ih/2-(ih/zoom/2)',trim=duration=$imageDuration [v2]; \
                  [3:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)+100':y='ih/2-(ih/zoom/2)',trim=duration=$imageDuration [v3]; \
                  [4:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)-100':y='ih/2-(ih/zoom/2)-100', fade=out:st=3:d=1,trim=duration=$imageDuration [v4]; \
                  [v0][v1] xfade=transition=slideup:duration=1:offset=4 [a]; \
                  [a][v2] xfade=transition=slideright:duration=1:offset=8 [b]; \
                  [b][v3] xfade=transition=slidedown:duration=1:offset=12 [c]; \
                  [c][v4] xfade=transition=slideleft:duration=1:offset=16 [v]; \
                  [v][6] overlay=10:10 [out] \
                  \" \
                  -pix_fmt yuv420p -c:v libx264 \
-map \"[out]\" -map 5 -shortest output.mp4  -y";


$r = exec($cmd);


/*
  Adicionado [v][6] overlay=10:10 [out]
  ao adicionar [], o primeiro referencia um output dentro de complex, o segundo a um input na primeira parte do código.
  No site abaixo, tem infos sobre posicionar melhor o logo mexendo no overlay '
  https://openwritings.net/pg/ffmpeg/ffmpeg-add-logo-video
*/


