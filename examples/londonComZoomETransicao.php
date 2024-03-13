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
-filter_complex \"
                  [0:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)+50':y='ih/2-(ih/zoom/2)',trim=duration=$imageDuration [v0]; \
                  [1:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)':y='ih/2-(ih/zoom/2)-50',trim=duration=$imageDuration [v1]; \
                  [2:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)+50':y='ih/2-(ih/zoom/2)',trim=duration=$imageDuration [v2]; \
                  [3:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)-50':y='ih/2-(ih/zoom/2)+50',trim=duration=$imageDuration [v3]; \
                  [4:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)-100':y='ih/2-(ih/zoom/2)-100', fade=out:st=3:d=1,trim=duration=$imageDuration [v4]; \
                  [v0][v1] xfade=transition=slideup:duration=1:offset=4 [a]; \
                  [a][v2] xfade=transition=slideright:duration=1:offset=8 [b]; \
                  [b][v3] xfade=transition=slidedown:duration=1:offset=12 [c]; \
                  [c][v4] xfade=transition=slideleft:duration=1:offset=16[v] \
                  \" \
                  -pix_fmt yuv420p -c:v libx264 \
-map \"[v]\"  londonComZoomETransacao.mp4 -y";


$r = exec($cmd);

/*
Como estou concatenando as imagens com as transições não preciso disto
[v0][v1][v2][v3][v4]concat=n=5:v=1:a=0,format=yuv420p[v], 
porém referente a animação de fade out pude perceber 2 coisas:
1. Se eu colocar a animação no fim com xFade 
"[c][v4] xfade=transition=slideleft:duration=1:offset=16, fade=out:st=4:d=1[v]"
A animação vai valer para o vídeo como um todo, então o fadeout começou no tempo 4 segundos independente da image.
2.Quando eu coloquei para ficar junto com o zoom, então espcífico-se para aquela imagem.


Para dar zoom no centro da imagem, sem isso vai para em direção ao canto superior esquerto da imagem
:x='iw/2-(iw/zoom/2)' centro horizontal da imagem
:y='ih/2-(ih/zoom/2)' centro vertical  da imagem

Neste exemplo:

Para a primeira imagem, x='iw/2-(iw/zoom/2)+50' desloca levemente para a direita.
Para a segunda imagem, y='ih/2-(ih/zoom/2)-50' desloca levemente para cima.
Para a terceira imagem, x='iw/2-(iw/zoom/2)-50' desloca levemente para a esquerda.
Para a quarta imagem, y='ih/2-(ih/zoom/2)+50' desloca levemente para baixo.

*/


