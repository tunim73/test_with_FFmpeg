<?php

$imageTime = 5; // tempo de cada imagem
$videoTime = $imageTime * 5 + 1; //tempo teórico de cada imagem * qtd imagens + 1 (bug que não vou consertar agora, por que acho que ele vai ser necessário quando for colocar um layout de finalização)
$imageTime++; //não retirar, o tempo de cada imagem é rebaixado em 1s por conta do offset

$durationAfade = 4;
$stAfade = $videoTime - $durationAfade - 1;

$quality = 'hd720'; //qualidade da imagem
$outputFrameRate = 25;
$zoomDuration = $outputFrameRate * $imageTime; //25 é o padrão de frames por segundo, durante $imageTime segundos 

$transitionTime = 0.5;
$transitionOffset = [];
for ($i = 1; $i <= 5; $i++) {
  $transitionOffset[] = $imageTime * $i - $i;
}

$postiionDrawBox = ['x' => 'iw/2-650', 'y' => 'ih/2+100'];

$text01 = "Teste com textos simples";
$fontFile = '/usr/share/fonts/truetype/freefont/FreeSerif.ttf';
$fontcolor = 'white@0.8'; // blue or 0x0000FF https://ffmpeg.org/ffmpeg-utils.html#color-syntax
$positionText = ['x' => 200, 'y' => 400];
$positionText2 = ['x' => 400, 'y' => 200];
$fontsize = 24;
$fileName = 'output.mp4';

$cmd = "ffmpeg \
-loop 1 -t 1 -i ./imgLondon/london-01.jpg \
-loop 1 -t 1 -i ./imgLondon/london-02.jpg \
-loop 1 -t 1 -i ./imgLondon/london-03.jpg \
-loop 1 -t 1 -i ./imgLondon/london-04.jpg \
-loop 1 -t 1 -i ./imgLondon/london-05.jpg \
-i ./audio/audio1.mp3 \
-i ./images3/logo.jpg \
-i ./images3/rec.png \
-filter_complex \"
                  [0:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)+100':y='ih/2-(ih/zoom/2)',trim=duration=$imageTime [v0]; \
                  [1:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)+100':y='ih/2-(ih/zoom/2)',trim=duration=$imageTime [v1]; \
                  [2:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)+100':y='ih/2-(ih/zoom/2)',trim=duration=$imageTime [v2]; \
                  [3:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)+100':y='ih/2-(ih/zoom/2)',trim=duration=$imageTime [v3]; \
                  [4:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality:x='iw/2-(iw/zoom/2)-100':y='ih/2-(ih/zoom/2)-100', fade=out:st=3:d=1,trim=duration=$imageTime [v4]; \
                  [v0][v1] xfade=transition=slideup:duration=$transitionTime:offset=$transitionOffset[0] [a]; \
                  [a][v2] xfade=transition=slideright:duration=$transitionTime:offset=$transitionOffset[1] [b]; \
                  [b][v3] xfade=transition=slidedown:duration=$transitionTime:offset=$transitionOffset[2] [c]; \
                  [c][v4] xfade=transition=slideleft:duration=$transitionTime:offset=$transitionOffset[3] [v]; \
                  [v][6] overlay=50:10 [logo]; \
                  [logo]drawbox=x=$postiionDrawBox[x]:y=$postiionDrawBox[y]:w=320:h=150:t=fill:color=Red@0.6[drawbox]; \
                  [drawbox] drawtext=fontfile=$fontFile:text=$text01:x=$positionText[x]:y=$positionText[y]:fontsize=$fontsize:fontcolor=$fontcolor:box=0[out]; \
                  [out][7] overlay=80:10 [out] \
                  \" \
                  -af \"afade=t=out:st=$stAfade:d=$durationAfade\" \
                  -c:v libx264 -r $outputFrameRate \
-map \"[out]\" -map 5 -shortest $fileName  -y";


echo $cmd . "\n \n \n";
$r = exec($cmd);


/* 
Retângulo preenchido
[overlayed]drawbox=x=iw-200:y=ih-200:w=200:h=200:t=fill:color=black@0.5[out] \

As coordenadas do drawbox tem referência o canto inferior direito do vídeo e é o canto superior direito do drawbox que a localização dele no vídeo. Por que estou usando 'iw' e 'ih' que pega a largura e a altura do vídeo.


drawtext=fontfile=/usr/share/fonts/truetype/freefont/FreeSerif.ttf:text='Test Text:x=100:y=50:fontsize=24:fontcolor=yellow@0.2:box=1:boxcolor=red@0.2


Não consegui fazer o arredondamento das bordas do draw box.
encontrei estes links que dão outras possibildiades https://superuser.com/questions/1504881/how-to-draw-a-round-rectangle-on-the-video-with-ffmpeg

https://stackoverflow.com/questions/32859841/give-a-video-rounded-transparent-edges-so-that-it-can-be-overlayed-on-another-vi/62400465#62400465


A primeira de opção é mais viável, mas para fazer daquele jeito, prefiro fazer os layouts num editor e anexar manualmente os layouts. Será mais fácil fazer assim, do que acrescentar outra lib ao projeto, ou adaptar essa função no stackoverflow para os layouts que preciso e vou precisar.

*/


/* 
  A duração do afade deverá ser -1 segundo em relação a duração do afade, para poder escutar o fim do aúdio.
  Caso não queira chegar no fim, pode alterar esta variável. Seria interessante, sincronizar o fade out do vídeo com o afade de saída do aúdio.
*/
