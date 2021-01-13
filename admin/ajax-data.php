<?php 
    include "config.php";
    session_start();
    date_default_timezone_set("Asia/Dhaka");
    $type=strip_tags(mysqli_real_escape_string($conn,$_POST['type']));

    if($type == 'delete_user'){
        $did = $_POST['id'];

        $sql= "DELETE FROM user WHERE id = '{$did}'";
        if(mysqli_query($conn,$sql)){
            echo "done";
        }
        else{
            echo "failed";
        }
    }
    if($type=='slide_product'){
        $pid=$_POST['pid'];
        $res_q=mysqli_query($conn,"SELECT * FROM slide_product WHERE product_id={$pid}");
        if(mysqli_num_rows($res_q)>0){

            $_SESSION['error_msg']="Sorry! Already Added!";
            echo "exist";
        }
        else{
            $date=date("Y-m-d h:i:sa");
            $sql="INSERT INTO slide_product(product_id,slide_sts,added_on) 
                VALUES({$pid},1,'{$date}')";
            if(mysqli_query($conn,$sql)){
                $_SESSION['success_msg']="Succefylly Added.";
                echo "done";
            }
        }
    }
?>