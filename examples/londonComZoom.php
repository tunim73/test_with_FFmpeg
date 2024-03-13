<?php

$imageDuration = 5; // temp
$quality = 'hd720';
$zoomDuration = 30 * $imageDuration; //30 frames (é hd720) por segundo, durante $imageDuration segundos 

$cmd = "ffmpeg \
-loop 1 -t 1 -i ./imgLondon/london-01.jpg \
-loop 1 -t 1 -i ./imgLondon/london-02.jpg \
-loop 1 -t 1 -i ./imgLondon/london-03.jpg \
-loop 1 -t 1 -i ./imgLondon/london-04.jpg \
-loop 1 -t 1 -i ./imgLondon/london-05.jpg \
-filter_complex \"
                  [0:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration [v0]; \
                  [1:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration [v1]; \
                  [2:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration [v2]; \
                  [3:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration [v3]; \
                  [4:v]zoompan=z='min(zoom+0.0010,1.5)':d=$zoomDuration:s=$quality,trim=duration=$imageDuration, fade=out:st=4:d=1 [v4]; \
                  [v0][v1][v2][v3][v4]concat=n=5:v=1:a=0,format=yuv420p[v]\" \
                  -pix_fmt yuv420p -c:v libx264 \
-map \"[v]\"  londonComZoom.mp4 -y";

$r = exec($cmd);

/* 
  Finalmente consegui. 
  Com aplicação de zoom em específico, ou pode ser porque estou usando o zoompan, o -t 5 começou a ser meio que ignorado as vezes, outras foi multiplicado pelo :d de cada imagem. Se retirar o trim=duration=$duration, isso volta a ocorrer.

  Outras explicações podem ser encontradas em animacaoImage.php

*/





/* 
Com 
  zoom_duration=1 não acontece nada
  =2 tem zoom, porém cada imagem tá dando zoom rápidos durante 10s e diversas vezes e reinicia
  =75 tem zoom, lentos, porém a imagem á sendo reiniciada diversas vezes 

  zoom_duration*cadaImagem*tempo_da_imagem = totalTime
  ao invés do zoom ocorrer durante o tempo destinado a imagem, ele acrescenta o tempo, tá confuso, mas tá indo
*/



/* 
z='zoom+0.001' significa que a cada frame aumento de 0.001+o zoom anterior

*/




/* $cmd = "ffmpeg \
    -loop 1 -t 2 -i ./imgLondon/london-01.jpg \
    -loop 1 -t 3 -i ./imgLondon/london-02.jpg \
    -loop 1 -t 2 -i ./imgLondon/london-03.jpg \
    -loop 1 -t 3 -i ./imgLondon/london-04.jpg \
    -loop 1 -t 4 -i ./imgLondon/london-05.jpg \
    -filter_complex \" zoompan=z='zoom+0.002':d=25*5:s=1280x800\" \
    -pix_fmt yuv420p -vcodec libx264 \
    -map \"[v]\" output.mp4 -y"; */



/* 
Animação de saída sendo aplicada no tempo st


$cmd = "ffmpeg \
-loop 1 -t 5 -i ./imgLondon/london-01.jpg \
-loop 1 -t 5 -i ./imgLondon/london-02.jpg \
-loop 1 -t 5 -i ./imgLondon/london-03.jpg \
-loop 1 -t 5 -i ./imgLondon/london-04.jpg \
-loop 1 -t 5 -i ./imgLondon/london-05.jpg \
-filter_complex \"[0:v]fade=out:st=4.5:d=1[v0]; \
                  [1:v]fade=out:st=4.5:d=1[v1]; \
                  [2:v]fade=out:st=4.5:d=1[v2]; \
                  [3:v]fade=out:st=4.5:d=1[v3]; \
                  [4:v]fade=out:st=4.5:d=1[v4]; \
                  [v0][v1][v2][v3][v4]concat=n=5:v=1:a=0,format=yuv420p[v]\" \
-map \"[v]\" output.mp4 -y";
 */








/* 
Não funcionou, cada imagem tá passando de 2.5 em 2.5 segundos, tirando a ultima imagem

$cmd = "ffmpeg \
    -loop 1 -t 2 -i ./imgLondon/london-01.jpg \
    -loop 1 -t 3 -i ./imgLondon/london-02.jpg \
    -loop 1 -t 2 -i ./imgLondon/london-03.jpg \
    -loop 1 -t 3 -i ./imgLondon/london-04.jpg \
    -loop 1 -t 4 -i ./imgLondon/london-05.jpg \
    -filter_complex \"[0:v]zoompan=z='min(zoom+0.0015,1.5)':d=$zoom_duration:x='iw/2-(iw/zoom/2)':y='ih/2-(ih/zoom/2)':s=hd720,fade=out:st=2:d=1[v0]; \
                      [1:v]zoompan=z='min(zoom+0.0015,1.5)':d=$zoom_duration:x='iw/2-(iw/zoom/2)':y='ih/2-(ih/zoom/2)':s=hd720,fade=out:st=3:d=1[v1]; \
                      [2:v]zoompan=z='min(zoom+0.0015,1.5)':d=$zoom_duration:x='iw/2-(iw/zoom/2)':y='ih/2-(ih/zoom/2)':s=hd720,fade=out:st=2:d=1[v2]; \
                      [3:v]zoompan=z='min(zoom+0.0015,1.5)':d=$zoom_duration:x='iw/2-(iw/zoom/2)':y='ih/2-(ih/zoom/2)':s=hd720,fade=out:st=3:d=1[v3]; \
                      [4:v]zoompan=z='min(zoom+0.0015,1.5)':d=$zoom_duration:x='iw/2-(iw/zoom/2)':y='ih/2-(ih/zoom/2)':s=hd720,fade=out:st=4:d=1[v4]; \
                      [v0][v1][v2][v3][v4]concat=n=5:v=1:a=0,format=yuv420p[v]\" \
    -map \"[v]\" output.mp4 -y"; */


/* $cmd = "ffmpeg \
-loop 1 -t 5 -i ./imgLondon/london-01.jpg \
-loop 1 -t 5 -i ./imgLondon/london-02.jpg \
-loop 1 -t 5 -i ./imgLondon/london-03.jpg \
-loop 1 -t 5 -i ./imgLondon/london-04.jpg \
-loop 1 -t 5 -i ./imgLondon/london-05.jpg \
-filter_complex \" \
    [0][1] xfade=transition=slideup:duration=1:offset=4 [a]; \
    [a][2] xfade=transition=slideright:duration=1:offset=8 [b]; \
    [b][3] xfade=transition=slidedown:duration=1:offset=12 [c]; \
    [c][4] xfade=transition=slideleft:duration=1:offset=16 [d]; \
    [0]fade=t=in:st=0:d=1:alpha=1,setpts=PTS+4/TB[fa0]; \
    [1]fade=t=in:st=0:d=1:alpha=1,setpts=PTS+4/TB[fa1]; \
    [2]fade=t=in:st=0:d=1:alpha=1,setpts=PTS+4/TB[fa2]; \
    [3]fade=t=in:st=0:d=1:alpha=1,setpts=PTS+4/TB[fa3]; \
    [4]fade=t=in:st=0:d=1:alpha=1,setpts=PTS+4/TB[fa4]; \
    [fa0]fade=t=out:st=4:d=1:alpha=1,setpts=PTS+16/TB[fa0out]; \
    [fa1]fade=t=out:st=4:d=1:alpha=1,setpts=PTS+16/TB[fa1out]; \
    [fa2]fade=t=out:st=4:d=1:alpha=1,setpts=PTS+16/TB[fa2out]; \
    [fa3]fade=t=out:st=4:d=1:alpha=1,setpts=PTS+16/TB[fa3out]; \
    [fa4]fade=t=out:st=4:d=1:alpha=1,setpts=PTS+16/TB[fa4out]; \
    [d][fa0out]overlay=x='if(gte(t,16),-w+(t-16)*w, -w)':y=0:eof_action=pass[out] \
    \" \
-pix_fmt yuv420p -vcodec libx264 \
-map \"[out]\" output.mp4 -y";
 */

/* Sem animação específica e a primeira imagem tem 24 segundos ou começou a apresentar no 20s, pois as outras imagens estão corretas, tirando a animação. 

$cmd = "ffmpeg \
    -loop 1 -t 5 -i ./imgLondon/london-01.jpg \
    -loop 1 -t 5 -i ./imgLondon/london-02.jpg \
    -loop 1 -t 5 -i ./imgLondon/london-03.jpg \
    -loop 1 -t 5 -i ./imgLondon/london-04.jpg \
    -loop 1 -t 5 -i ./imgLondon/london-05.jpg \
    -filter_complex \" \
        [0][1] xfade=transition=slideup:duration=1:offset=4 [a]; \
        [a][2] xfade=transition=slideright:duration=1:offset=8 [b]; \
        [b][3] xfade=transition=slidedown:duration=1:offset=12 [c]; \
        [c][4] xfade=transition=slideleft:duration=1:offset=16 [d]; \
        [d]fade=t=in:st=0:d=1:alpha=1,setpts=PTS+4/TB, \
        fade=t=out:st=4:d=1:alpha=1,setpts=PTS+16/TB[out] \
        \" \
    -pix_fmt yuv420p -vcodec libx264 \
    -map \"[out]\" output.mp4 -y"; */


