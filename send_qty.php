<?php  
include "config.php";

$qty = $_POST['quantity'];
$pdt_id = $_POST['pdt_id'];

$sql = "UPDATE cart SET cart_qty={$qty} WHERE product_id={$pdt_id}";
if(mysqli_query($conn,$sql)){
    echo "Insertation Successful";
}
else{
    echo "Insertaion Failed";
}


?>