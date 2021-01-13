<?php
   include "config.php";
   require('top.inc.php');
   if(isset($_GET['type'])){
      $type = $_GET['type'];
      if($type=='delete'){
         $buy_id = $_GET['bid'];
   
         $dlt_sql = "DELETE FROM buy WHERE buy_id = {$buy_id}";
         mysqli_query($conn,$dlt_sql);
      }
   }
   if(isset($_GET['st'])){
      $sql = "SELECT * FROM buy 
      LEFT JOIN product ON buy.product_id = product.product_id
      LEFT JOIN checkout ON buy.chk_id = checkout.checkout_id
      LEFT JOIN user ON buy.user_id = user.id
      WHERE buy.date > DATE_SUB(NOW(), INTERVAL 24 HOUR)
      ORDER BY buy.buy_id DESC";
   }else{
      $sql = "SELECT * FROM buy 
      LEFT JOIN product ON buy.product_id = product.product_id
      LEFT JOIN checkout ON buy.chk_id = checkout.checkout_id
      LEFT JOIN user ON buy.user_id = user.id
      ORDER BY buy.buy_id DESC";
   }
   
   $res = mysqli_query($conn,$sql) or die("Query Failed");
?>
<div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <?php if(mysqli_num_rows($res) > 0) { ?>
                           <a href="../order_pdf.php"><img class="admin_pdf"  src="../images/logo/pdf.png"></a>
                           <?php } ?>
                           <h4 class="box-title">Order Master </h4>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th>S.No</th>
                                       <th>ID</th>
                                       <th>Product</th>
                                       <th>Image</th>
                                       <th>Price</th>
                                       <th>Quantity</th>
                                       <th>Discount</th>
                                       <th>Date</th>
                                       <th>Address</th>
                                       <th>UserName</th>
                                       <th></th>
                                       <th></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                  <?php $i=1; while($row = mysqli_fetch_assoc($res)){ ?>
									    <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $row['buy_id']; ?></td>
                                            <td><?php echo $row['product_name']; ?></td>
                                            <td class="avatar pb-0">
                                             <div class="round-img">
                                                <a href="#"><img class="rounded-circle" src="upload/<?php echo $row['img']; ?>" alt=""></a>
                                             </div>
                                            </td>
                                            <td><?php echo "&#2547;".$row['price']; ?></td>
                                            <td><?php echo $row['sell_qty']; ?></td>
                                            <td><?php
                                                if($row['discount']==0){
                                                   echo "Not Use";
                                                }
                                                else{
                                                   echo $row['discount']."%";
                                                }?>
                                             </td>
                                            <td><?php echo $row['date']; ?></td>
                                            <td><?php echo $row['address']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td class='delete'><span class='badge badge-pending'><a href='order.php?type=delete&bid=<?php echo $row['buy_id']; ?>'>Delete</a></span></td>
                                        </tr>
                                  <?php } ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
		  </div>
         
<?php
require('footer.inc.php');
?>