<?php  
include "config.php";
function get_string($conn,$str){
    if($str!=''){
        $str=trim($str);
        return strip_tags(mysqli_real_escape_string($conn,$str));
    }
}
?>