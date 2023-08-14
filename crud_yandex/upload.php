<?php

require_once(__DIR__."/vendor/autoload.php");
require_once(__DIR__."/classes/DiskManager.php");

try {
  $diskHandler = new DiskManager($token);
  $diskHandler->uploadFile($_FILES['file']);

  header('location: index.php');
} 
catch(Exception $e) {
  echo $e->getMessage();
}
