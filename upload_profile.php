<?php
include "config.php";
session_start();
$user_id=$_SESSION['user_id'];
if(isset($_FILES['file']['name'])){

   /* Getting file name */
   $filename = $_FILES['file']['name'];

   /* Location */
   $location = "admin/upload/".$filename;
   $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
   $imageFileType = strtolower($imageFileType);

   /* Valid extensions */
   $valid_extensions = array("jpg","jpeg","png");

   $response = 0;
   /* Check file extension */
   if(in_array(strtolower($imageFileType), $valid_extensions)) {
      /* Upload file */
      if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
      $sql="UPDATE user SET img='{$filename}' WHERE id={$user_id}";
        if(mysqli_query($conn,$sql)){
                $response=$location;
            }
      }
   }
   echo $response;
   exit;
}

echo 0;

