<?php 

    include "config.php";
    include "function.inc.php";
    session_start();
    date_default_timezone_set("Asia/Dhaka");
    $type = get_string($conn,$_POST['type']);
    $name = get_string($conn,$_POST['name']);
    $address = get_string($conn,$_POST['address']);
    $email = get_string($conn,$_POST['email']);
    $phn = get_string($conn,$_POST['phone']);
    $payment = get_string($conn,$_POST['payment']);
    $del_charge=300;
    if($payment=='cash'){
        $order_status=1;
    }
    else {
        $order_status=2;
    }
    $date =date("Y-m-d h:i:s");
    $user_id=$_SESSION['user_id'];
    $res_del_boy=mysqli_query($conn,"SELECT del_boy_id FROM delivery_boy ORDER BY RAND() LIMIT 1");
    if(mysqli_num_rows($res_del_boy)>0){
        while($row_del = mysqli_fetch_assoc($res_del_boy)){
            $del_boy_id=$row_del['del_boy_id'];
        }
    }
    
    $sql="INSERT INTO checkout(name,email,phn,user_id,date,address,payment,order_status,del_boy_id,amount_type)
        VALUES('{$name}','{$email}','{$phn}','{$user_id}','{$date}','{$address}','{$payment}',{$order_status},{$del_boy_id},'{$type}')";
    if(mysqli_query($conn,$sql)){
        $sql_chk = "SELECT * FROM checkout WHERE date='{$date}'";
        $res_chk=mysqli_query($conn,$sql_chk);
        $row_chk=mysqli_fetch_assoc($res_chk);
        $sql_cart = "SELECT * FROM cart JOIN product ON cart.product_id=product.product_id 
        ORDER BY cart_id DESC";
        $res_cart =mysqli_query($conn,$sql_cart);
        $chk_id = $row_chk['checkout_id'];
        $order_pid=array();
        while($row_cart=mysqli_fetch_assoc($res_cart)){
            
            $result="";
            $pdt_id =$row_cart['product_id'];
            $cart_qty = $row_cart['cart_qty'];
            if(isset($_SESSION['discount'])){
                $discount =$_SESSION['discount'];
            }
            else{
                $discount=0;
            }
            $order_pid[]=$pdt_id;
            if($type=='coin'){
                $user_coin = ($cart_qty*$row_cart['coin'])+$del_charge;
                
                $user_updt = "UPDATE user SET user_coin=user_coin-{$user_coin} WHERE id={$user_id}";
                if(mysqli_query($conn,$user_updt)){
                    $del_charge=0;
                }
                else{
                    die();
                }
            }
            $sql3 ="INSERT INTO buy(product_id,date,user_id,sell_qty,discount,chk_id) VALUES({$pdt_id},'{$date}',{$user_id},{$cart_qty},{$discount},{$chk_id})";
            if(mysqli_query($conn,$sql3)){
                $qty =$row_cart['cart_qty'];
                $sql4="UPDATE product SET qty=qty-{$qty} WHERE product_id={$pdt_id};";
                if(mysqli_query($conn,$sql4)){
                    $sql_dlt ="DELETE FROM cart WHERE product_id={$pdt_id};";
                    if(mysqli_query($conn,$sql_dlt)){ 
                        unset($_SESSION['discount']);
                        $_SESSION['order_pid']=$order_pid;
                        $result= "success";
                     }
                    
                }
                
            }
        }
        echo $result;

    }

?>