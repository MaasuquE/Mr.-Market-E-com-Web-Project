<?php
    include "config.php";
    ob_start();
    include "toper.php";
    if(!isset($_SESSION['USER_LOGIN'])){
        header("Location: {$hostname}/login.php");
    }
    if(isset($_GET['cid'])){
        $chk_id=$_GET['cid'];
        $res_chk=mysqli_query($conn,"SELECT * FROM checkout WHERE checkout_id={$chk_id}");
        if(mysqli_num_rows($res_chk)>0){
            $del ="DELETE FROM checkout WHERE checkout_id={$chk_id};";
            $del .="DELETE FROM buy WHERE chkt_id={$chk_id}";
            if(mysqli_multi_query($conn,$del)){
                header("Location: {$hostname}/my_order.php");
                ob_end_flush();
            }
        }
        
    }
    $user_id = $_SESSION['user_id'];
    $sql="SELECT *,DATE(date) AS date_part,TIME(date) AS time_part FROM checkout 
    JOIN delivery_boy ON checkout.del_boy_id=delivery_boy.del_boy_id
    WHERE user_id={$user_id} ORDER BY checkout_id DESC";
    $res=mysqli_query($conn,$sql);
    if(mysqli_num_rows($res)>0){

?>

<div class="container">
    
    <div class="order_sec">
        <h3>Order Table</h3>
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
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody >
            <?php
            $i=1;
            while($row=mysqli_fetch_assoc($res)){
                
            ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><b>Name:</b> <?php echo $row['name']; ?> <br><b>Email:</b><?php echo $row['email']; ?> <br><b>Mobile: </b><?php echo $row['phn']; ?></td>
                    <td><?php echo $row['address']; ?><br><b>Date: </b><?php echo $row['date_part']; ?><br><b>Time: </b><?php echo trim($row['time_part'],'.000000'); ?></td>
                    <td><b>Name: </b><?php echo $row['boy_name']; ?><br><b>Contact: </b><?php echo $row['mobile']; ?></td>
                    <td><table class="inner_table"><thead><tr><th>Image</th><th>Dish-id</th><th>Dish-Name</th><th>Price</th><th>Quantity</th></tr></thead>
                        <?php 
                            $total=0;
                            $chk_id=$row['checkout_id'];
                            $res_or=mysqli_query($conn,"SELECT * FROM buy
                            LEFT JOIN product ON buy.product_id=product.product_id
                                WHERE buy.chk_id={$chk_id} ORDER BY buy.buy_id DESC");
                            if(mysqli_num_rows($res_or)>0){

                            while($row_or=mysqli_fetch_assoc($res_or)){
                        ?>    
                        <?php if($row['amount_type']=='coin'){ ?>                    
                            <tbody>
                                <tr>
                                    <td><a href="product-details.php?pid=<?php echo $row_or['product_id'];  ?>"><img src="admin/upload/<?php echo $row_or['img']; ?>" alt="Click to Details"></a></td>
                                    <td><?php echo $row_or['buy_id']; ?></td>
                                    <td><a href="product-details.php?pid=<?php echo $row_or['product_id'];  ?>"><?php echo $row_or['product_name']; ?></a></td>
                                    <td><i class="fas fa-coins"></i> <?php echo $row_or['coin']; ?></td>
                                    <td><?php echo $row_or['sell_qty']; ?></td>
                                </tr>
                                <?php 
                                    $total+=($row_or['coin']*$row_or['sell_qty']);?>
                            </tbody>                          
                        <?php  } else{ ?>
                            <tbody>
                                <tr>
                                    <td><a href="product-details.php?pid=<?php echo $row_or['product_id'];  ?>"><img src="admin/upload/<?php echo $row_or['img']; ?>" alt="Click to Details"></a></td>
                                    <td><?php echo $row_or['buy_id']; ?></td>
                                    <td><a href="product-details.php?pid=<?php echo $row_or['product_id'];  ?>"><?php echo $row_or['product_name']; ?></a></td>
                                    <td><?php echo $row_or['price']; ?></td>
                                    <td><?php echo $row_or['sell_qty']; ?></td>
                                </tr>
                                <?php 
                                    $total+=($row_or['price']*$row_or['sell_qty']);
                                    ?>
                            </tbody>
                            <?php  }} ?>
                            <?php if($row['amount_type']=='coin'){ ?>
                                <tfoot>
                                <tr>
                                    <td colspan="2">Delivery Charge</td>
                                    <td colspan="3"><i class="fas fa-coins"></i> 300</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td colspan="3"><i class="fas fa-coins"></i> <?php echo $total+300; ?></td>
                                </tr>
                                <?php  } else{ ?>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Delivery Charge</td>
                                            <td colspan="3">60 tk</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Total</td>
                                            <td colspan="3"><?php echo $total+60; ?></td>
                                        </tr>
                                        
                                    </tfoot>
                                    <?php }}?>
                                </tfoot>
                            
                        </table>
                        
                    </td>
                    <td><?php echo $row['payment']; ?></td>
                    <td><?php
                        if($row['payment']=="online"){
                            echo '<span class="ord_success">success</span></td>';
                        }
                        else{
                            echo '<span class="ord_pending">Pending</span></td>';
                        }
                    ?>
                    <td><a href="order_pdf.php?cid=<?php echo $row['checkout_id']; ?>"><i class="far fa-file-pdf"></i></a></td>
                    <td><a href="my_order.php?cid=<?php echo $row['checkout_id']; ?>"><i class="far fa-trash-alt"></i></a></td>
                    
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } ?>
    </div>
</div>
        <!-- The Modal -->
        <?php if(isset($_SESSION['order_pid'])){ ?>
        <div class="order_rating">
            <div id="myModal" class="modal">

            <!-- Modal content -->
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close">&times;</span>
                        <h2>Give me rate</h2>
                    </div>
                    <div class="modal-body">
                        <section class='rating-widget'>
    
                            <!-- Rating Stars Box -->
                            <div class='rating-stars text-center'>
                                <ul id='stars'>
                                <li class='star' title='Poor' data-value='1'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Fair' data-value='2'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Good' data-value='3'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Excellent' data-value='4'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='WOW!!!' data-value='5'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                </ul>
                            </div>
                            
                            <div class='success-box'>
                                <div class='clearfix'></div>
                                <img alt='tick image' width='32' src='data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA0MjYuNjY3IDQyNi42NjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQyNi42NjcgNDI2LjY2NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxwYXRoIHN0eWxlPSJmaWxsOiM2QUMyNTk7IiBkPSJNMjEzLjMzMywwQzk1LjUxOCwwLDAsOTUuNTE0LDAsMjEzLjMzM3M5NS41MTgsMjEzLjMzMywyMTMuMzMzLDIxMy4zMzMgIGMxMTcuODI4LDAsMjEzLjMzMy05NS41MTQsMjEzLjMzMy0yMTMuMzMzUzMzMS4xNTcsMCwyMTMuMzMzLDB6IE0xNzQuMTk5LDMyMi45MThsLTkzLjkzNS05My45MzFsMzEuMzA5LTMxLjMwOWw2Mi42MjYsNjIuNjIyICBsMTQwLjg5NC0xNDAuODk4bDMxLjMwOSwzMS4zMDlMMTc0LjE5OSwzMjIuOTE4eiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K'/>
                                <div class='text-message'>Please Give Me Rating....</div>
                                <div class='clearfix'></div>
                            </div>
                            
                            
                            
                        </section>
                        <button>Done</button>
                    </div>
                    
                </div>

            </div>
        </div>
        
        <?php
            }
            include "footer.php";
        ?>