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
                  [v][6] overlay=10:10 [overlayed]; \
                  [overlayed]drawbox=x=-t:y=0.5*(ih-iw/2.4)-t:w=iw+t*2:h=iw/2.4+t*2:t=2:c=red [drawbox]; \
                  [drawbox] drawtext=fontfile=/usr/share/fonts/truetype/freefont/FreeSerif.ttf:text='Test Text':x=200:y=100:fontsize=24:fontcolor=black@0.8:box=1:boxcolor=red@0.2 [out] \
                  \" \
                  -pix_fmt yuv420p -c:v libx264 \
-map \"[out]\" -map 5 -shortest output.mp4  -y";


$r = exec($cmd);


/* 
Retângulo preenchido
[overlayed]drawbox=x=iw-200:y=ih-200:w=200:h=200:t=fill:color=black@0.5[out] \

drawtext=fontfile=/usr/share/fonts/truetype/freefont/FreeSerif.ttf:text='Test Text:x=100:y=50:fontsize=24:fontcolor=yellow@0.2:box=1:boxcolor=red@0.2


*/