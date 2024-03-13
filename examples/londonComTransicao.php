<?php
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
        [c][4] xfade=transition=slideleft:duration=1:offset=16 [out] \
        \" \
    -pix_fmt yuv420p -vcodec libx264 \
    -map \"[out]\" output.mp4 -y";  

$r = exec($cmd);

/*
Variáveis

nome das imagens

duração e tempo das transações
- t e offset
o tempo (-t) é uma variável e tempo no offset tem que estar de acordo, fiz alguns testes e se não tiverem de acordo as transações ficam meio aleatórias, ora acontece, ora não, ou antes do previsto.

[a][b][c]
utilização de letras para fazer a transação,pode ser outra variável, desde que continue no padrão e evite números
para não ter algum tipo de conflito

tipo da transação 
slideup

nome do arquivo final

*/



/* 
Transações adicionadas
Teve que específicar o codec a ser utilizado
*/