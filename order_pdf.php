<?php  
    include "vendor/autoload.php";
    include "config.php";
    session_start();
    if(!isset($_SESSION['ADMIN_LOGIN'])){
        if(!isset($_SESSION['USER_LOGIN'])){
            die();
        }
    }
    if(isset($_GET['cid'])){
        $chk_id =$_GET['cid'];
    }
    $css=file_get_contents('css/bootstrap.min.css');
    $css.=file_get_contents('css\custom.css');

    $sql="SELECT *,DATE(date) AS date_part,TIME(date) AS time_part FROM checkout 
    JOIN delivery_boy ON checkout.del_boy_id=delivery_boy.del_boy_id
    WHERE checkout_id={$chk_id} ORDER BY checkout_id DESC";
    $res=mysqli_query($conn,$sql);
    
    $html='<div class="order_sec"><h3>Order Table</h3>
    <table class="order_table">
        <thead class="main_head">
            <tr>
                <th>Order No.</th>
                <th>Personal Info.</th>
                <th>Address</th>
                <th>Delivery Boy</th>
                <th>Order Details</th>
                <th>Payment Method</th>
                <th>Order Status</th>
            </tr>
        </thead>
        <tbody >';
        $i=1;
        if(mysqli_num_rows($res)>0){
        while($row=mysqli_fetch_assoc($res)){
           $html.='<tr>
                <td>'.$i++.'</td>
                <td><b>Name:</b> '.$row['name'].' <br><b>Email:</b>'.$row['email'].' <br><b>Mobile: </b>'.$row['phn'].'</td>
                <td>'.$row['address'].'<br><b>Date: </b>'.$row['date_part'].'<br><b>Time: </b>'.trim($row['time_part'],'.000000').'</td>
                <td><b>Name: </b>'.$row['boy_name'].'<br><b>Contact: </b>'.$row['mobile'].'</td>
                <td><table class="inner_table"><thead><tr><th>Dish-id</th><th>Dish-Name</th><th>Price</th><th>Quantity</th></tr></thead>
                    <tbody>';
                            $total=0;
                            $res_or=mysqli_query($conn,"SELECT * FROM buy
                            LEFT JOIN product ON buy.product_id=product.product_id
                             WHERE buy.chk_id={$chk_id} ORDER BY buy.buy_id DESC");
                            if(mysqli_num_rows($res_or)>0){

                            while($row_or=mysqli_fetch_assoc($res_or)){
                        
                        $html.='<tr>
                            <td>'.$row_or['buy_id'].'</td>
                            <td>'.$row_or['product_name'].'</td>
                            <td>'.$row_or['price'].'</td>
                            <td>'.$row_or['sell_qty'].'</td>
                        </tr>';
                            $total+=($row_or['price']*$row_or['sell_qty']);
                            }
                         }
                    $html.='</tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Delivery Charge</td>
                            <td colspan="2">60 tk</td>
                        </tr>
                        <tr>
                            <td colspan="2">Total</td>
                            <td colspan="2">'.($total+60).'</td>
                        </tr>
                        
                    </tfoot>
                    </table>
                </td>
                <td>'.$row['payment'].'</td>
                <td>';
                    if($row['payment']=="online"){
                    $html.='<span class="ord_success">success</span></td>';
                    }
                    else{
                       $html.='<span class="ord_pending">Pending</span></td>';
                    }
                $html.='</td> 
            </tr>';
             } 
        }
        $html.='</tbody>
    </table></div><h5>&copy;Maasque 2020</h5>';

    

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($css,1);
    $mpdf->WriteHTML($html,2);
    $file=time().'.pdf';
    $mpdf->Output($file,'D');
?>