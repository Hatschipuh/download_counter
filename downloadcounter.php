<?php

// ===== Pfad aufbereitung - begin
$strURL = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
$strURL = str_replace("downloadcounter.php?","",$strURL);
$strURL2 = str_replace($_SERVER['QUERY_STRING'], "", $strURL);

// set example variables
$filename = $_SERVER['QUERY_STRING'];
//$filepath = "/var/www/domain/httpdocs/download/path/";
$filepath = __DIR__.'/';
// ===== Pfad aufbereitung - end















// ===== Counter - begin
if (!is_dir("download_counter")) {  mkdir ("download_counter", 0777); } 

 $counter_datei = 'download_counter/download_counter.csv';
 
 if (!file_exists($counter_datei)) {   // Nur wegen der Überschrift
  $fp=fopen($counter_datei,"a+");
  fwrite($fp,"Date Hour ; Filename Download Zip ; IP User ; Referrer, Download from Site\r\n");
  fclose($fp);     
 }
  
  date_default_timezone_set("Europe/Berlin");
 $timestamp = time();
  $fp=fopen($counter_datei,"a+");
  fwrite($fp,date("Y.m.d H:i",$timestamp).' ; '.$filename .' ; '.$_SERVER['REMOTE_ADDR'] .' ; '.$_SERVER['HTTP_REFERER']."\r\n");
  fclose($fp);  

// ===== Counter - end






// ===== ZIP an browser senden - begin
// http headers for zip downloads
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"".$filename."\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($filepath.$filename));
ob_end_flush();
@readfile($filepath.$filename);
// ===== ZIP an browser senden - end


?>