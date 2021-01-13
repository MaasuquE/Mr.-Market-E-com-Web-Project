<?php
    include "config.php"; 
    $cart_id=$_POST['cart_id'];

    $sql = "DELETE FROM cart WHERE cart_id={$cart_id}";  
    mysqli_query($conn,$sql);  
?>