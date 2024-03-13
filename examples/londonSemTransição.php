<?php
$cmd = "ffmpeg \
    -loop 1 -t 2 -i ./imgLondon/london-01.jpg \
    -loop 1 -t 3 -i ./imgLondon/london-02.jpg \
    -loop 1 -t 2 -i ./imgLondon/london-03.jpg \
    -loop 1 -t 3 -i ./imgLondon/london-04.jpg \
    -loop 1 -t 4 -i ./imgLondon/london-05.jpg \
    -filter_complex \"[0][1][2][3][4] concat=n=5 [out]\" \
    -map \"[out]\" output.mp4";

$r = exec($cmd);
