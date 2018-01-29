<?php
  $rawpic = $_POST['pic'];
  $pic = imagecreatefromstring(base64_decode($rawpic));
  $idfilter = $_POST['img'];
  $filter = imagecreatefrompng("./filters/img" . $idfilter . ".png");
  imagealphablending($filter, false);
  imagesavealpha($filter, true);
  if ($idfilter == 2)
    imagecopy($pic, $filter, 140, 90, 0, 0, 90, 20); 
  else if ($idfilter == 1)
  imagecopy($pic, $filter, 10, 10, 0, 0, 90, 90);
  else
    imagecopy($pic, $filter, 10, 10, 0, 0, 80, 80);
  ob_start();
  imagejpeg($pic, null, 100);
  $contents = ob_get_contents();
  ob_end_clean();
  echo json_encode(base64_encode($contents));
  imagedestroy($pic);
  imagedestroy($filter);
?>