<?php 
include "config.php";
    $res=mysqli_query($conn,"SELECT DATE(visiting_date) AS date_part, TIME(visiting_date) AS time_part FROM visitor");
    if(mysqli_num_rows($res)>0){
        while($row=mysqli_fetch_assoc($res)){
            echo $row['date_part']."  ///  ".$row['time_part']."</br>";
        }
    }
?>