<?php
$cmd = "ffmpeg -loop 1 -i ./imgLondon/london-01.jpg -t 8 -vf \"zoompan=z='min(zoom+0.0015,1.5)':d=125\"  -c:v libx264 -s '800x450'  animacaoImagem.mp4 -y";




$r = exec($cmd);

/* 
Com d menor que o tempo total da imagem, o zoom retorna até cumprir o tempo correto
Aparentemente o -t 5 só é respeitado após o carregamento da imagem com -i, mas isso só para imagens, 
na situação de um vídeo de slides ocorre inconsistências dependendo efeitos vizuais de cada imagem aplicados no filter_complex.
*/