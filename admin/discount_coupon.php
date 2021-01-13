<?php
   include "config.php";
   require('top.inc.php');
   if(isset($_GET['type'])){
      $type = $_GET['type'];
      if($type == 'status'){
         $cat_id =$_GET['cid'];
         if($_GET['sts']==1){
            unset($_SESSION['discount']);
            $status = 0;
         }
         else{
            $status =1;
         }
   
      $updt_sql = "UPDATE coupon SET status ={$status} WHERE coupon_id ={$cat_id};";
      mysqli_query($conn,$updt_sql);
      }
   
      if($type=='delete'){
         $cat_id = $_GET['cid'];
   
         $dlt_sql = "DELETE FROM coupon WHERE coupon_id = {$cat_id}";
         mysqli_query($conn,$dlt_sql);
      }
   }
?>
<div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="box-title">Discount Coupon</h4>
						   <h4 class="box_title_link " ><a href="add_coupon.php">Add Coupon</a> </h4>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                              <?php   
                                 $sql = "SELECT * FROM coupon ORDER BY coupon_id DESC";
                                 $res = mysqli_query($conn,$sql) or die("Query Failed");
                              
                              ?>
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th>S.No</th>
                                       <th>Coupon ID</th>
                                       <th>Coupon Code</th>
                                       <th>Discount(%)</th>
                                       <th>Status</th>
                                       <th>Used Time</th>
                                       <th>Edit</th>
                                       <th>Delete</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                  <?php $i=1; while($row = mysqli_fetch_assoc($res)){ ?>
									         <tr>
                                       <td><?php echo $i++; ?></td>
                                       <td><?php echo $row['coupon_id']; ?></td>
									    <td><?php echo $row['coupon']; ?></td>
                                       <td><?php echo $row['discount']."%"; ?></td>
                                       <td><?php
                                          if($row['status'] == '1'){
                                             echo "<span class='badge badge-complete'><a style='color:white' href='discount_coupon.php?type=status&sts=".$row['status']."&cid=".$row['coupon_id']."'>Active</a></span>";
                                          }else{
                                             echo "<span class='badge badge-pending'><a style='color:white' href='discount_coupon.php?type=status&sts=".$row['status']."&cid=".$row['coupon_id']."'>Deactive</a></span>";
                                          }
                                       ?></td>
                                       <td><?php echo $row['uses_time']." times"; ?></td>
                                       <td class='edit'><span class='badge badge-complete'><a href='update-discount_coupon.php?cid=<?php echo $row['coupon_id']; ?>'>Edit<i class='fa fa-edit'></i></a></span></td>
                                       <td class='delete'><span class='badge badge-pending'><a href='discount_coupon.php?type=delete&cid=<?php echo $row['coupon_id']; ?>'>Delete</a></span></td>
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
