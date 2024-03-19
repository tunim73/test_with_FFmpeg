<?php

$imageDirectory = dirname(__FILE__) . '/../imgLondon';

$files = glob($imageDirectory . '/*.jpg');

$cmd = "ffmpeg \\";
$filter_complex = "-filter_complex \" ";
$config = "-map \"[out]\" output.mp4 -y";


foreach ($files as $index => $file) {

  $cmd .= "-loop 1 -t 2 -i $file \\";
  $filter_complex .= "[$index]";

  if ($index === count($files) - 1) {
    $countFiles = count($files);
    $filter_complex .= "concat=n=$countFiles [out] \" \\";
  }

}

$cmd .= $filter_complex;
$cmd .= $config;


exec($cmd);


/* 

ffmpeg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-01.jpg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-02.jpg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-03.jpg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-04.jpg \-loop 1 -t 2 -i /home/antonio/work/imovelguide/test_with_ffmpeg/src/../imgLondon/london-05.jpg \-filter_complex " [0][1][2][3][4] concat=n=5 [out] " \-map "[out]" output.mp4 -y

*/







