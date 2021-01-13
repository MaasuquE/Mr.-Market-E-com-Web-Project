<?php  
include "config.php";
session_start();
$qty = $_POST['quantity'];
$pdt_id = $_POST['pdt_id'];
$type = $_POST['type'];
$size = $_POST['size'];

$date = date("d M, Y h:i:s");
$user_id = $_SESSION['user_id']; 
$sql_pdt="SELECT * FROM cart WHERE product_id = {$pdt_id} AND user_id={$user_id} AND buy_type='{$type}'";
$res_pdt = mysqli_query($conn,$sql_pdt);
if(mysqli_num_rows($res_pdt) > 0){
    $cart_updt =mysqli_query($conn,"UPDATE cart SET cart_qty={$qty},size='{$size}'");
}else{
    $sql_insrt = "INSERT INTO cart(product_id,added_on,cart_qty,user_id,buy_type,size)
            VALUES('{$pdt_id}','{$date}',{$qty},{$user_id},'{$type}','{$size}')";
            if(mysqli_query($conn,$sql_insrt)){
                $sql_dlt = "DELETE FROM wishlist WHERE product_id={$pdt_id}";
                mysqli_query($conn,$sql_dlt);
            }else {
                echo "Failed";
            }
}

?>