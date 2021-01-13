<?php
include "config.php";
if(isset($_FILES['file']['name'])){
   $filename = $_FILES['file']['name'];
   $location = "upload/".$filename;
   $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
   $imageFileType = strtolower($imageFileType);
   $valid_extensions = array("jpg","jpeg","png");

   $response = 0;
   if(in_array(strtolower($imageFileType), $valid_extensions)) {
      if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
        $response=1;
      }
   }
   echo $response;
   exit;
}

echo 0;

