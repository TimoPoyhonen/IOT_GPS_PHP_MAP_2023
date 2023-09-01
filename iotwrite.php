<?php
    $_POST = file_get_contents('php://input');
    $myYear = date("d.m.Y");
    $myHour = date("H:i");
    $myFile = "data/iotlogs.txt";
    $myFileBackup = "iotwrite.txt";
    $fh = fopen($myFile, 'a') or die("can't open file");
    $fhBackup = fopen($myFileBackup, 'a') or die("can't open backup file");
    fwrite($fh, $myYear . " " .  $myHour);
    fwrite($fh, "\t");
    fwrite($fh, $_POST);
    fwrite($fh, "\n");   
    fclose($fh);
    fwrite($fhBackup, $myYear . " " .  $myHour);
    fwrite($fhBackup, "\t");
    fwrite($fhBackup, $_POST);
    fwrite($fhBackup, "\n");    
    fclose($fhBackup);

?>