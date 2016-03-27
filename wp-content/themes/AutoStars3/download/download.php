<?php
$file = $_GET['file'];
$ext = pathinfo($file, PATHINFO_EXTENSION);
$match_array =array('pdf');
if(in_array($ext,$match_array)){
header("Content-type: application/".$ext);
header("Content-Disposition: attachment; filename=". $file);
readfile($file);
}
?>