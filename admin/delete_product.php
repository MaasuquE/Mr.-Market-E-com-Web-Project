<?php
    include "config.php"; 
    $pdt_id=$_POST['pdt_id'];

    $sql = "DELETE FROM product WHERE product_id={$pdt_id}";  
    mysqli_query($conn,$sql);  
?>