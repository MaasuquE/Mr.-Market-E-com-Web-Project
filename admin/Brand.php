<?php
   include "config.php";
   date_default_timezone_set("Asia/Dhaka");
   require('top.inc.php');
   if(isset($_GET['type'])){
      $type = $_GET['type'];
      if($type == 'status'){
         $brand_id =$_GET['cid'];
         if($_GET['sts']==1){
            $status = 0;
         }
         else{
            $status =1;
         }
   
      $updt_sql = "UPDATE brand SET brand_sts ={$status} WHERE brand_id ={$brand_id};";
      mysqli_query($conn,$updt_sql);
      }
   
      if($type=='delete'){
         $brand_id = $_GET['cid'];
   
         $dlt_sql = "DELETE FROM brand WHERE brand_id = {$brand_id}";
         if(mysqli_query($conn,$dlt_sql)){
            
         }
      }
   }
?>
<div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="box-title">Brand Master</h4>
						   <h4 class="box_title_link " ><a href="add_brand.php">Add Brand</a> </h4>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                              <?php   
                                 $sql = "SELECT * FROM brand JOIN category ON brand.brand_cat=category.category_id ORDER BY brand.brand_id DESC";
                                 
                                 $res = mysqli_query($conn,$sql) or die("Query Failed");
                              
                              ?>
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th>S.No</th>
                                       <th>ID</th>
                                       <th>Brand </th>
                                       <th>Category </th>
                                       <th>UserName </th>
                                       <th>Email </th>
                                       <th>City </th>
                                       <th>Address </th>
                                       <th>Licence </th>
                                       <th>Status</th>
                                       <th>Edit</th>
                                       <th>Delete</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                  <?php
                                    if(mysqli_num_rows($res)>0)
                                  $i=1; while($row = mysqli_fetch_assoc($res)){ ?>
									         <tr>
                                       <td><?php echo $i++; ?></td>
                                       <td><?php echo $row['brand_id']; ?></td>
                                       <td><?php echo $row['brand_name']; ?></td>
                                       <td><?php echo $row['category_name']; ?></td>
                                       <td><?php echo $row['user_name']; ?></td>
                                       <td><?php echo $row['email']; ?></td>
                                       <td><?php echo $row['city']; ?></td>
                                       <td><?php echo $row['address']; ?></td>
                                       <td><?php echo $row['licence']; ?></td>
                                       <td><?php
                                          if($row['brand_sts'] == '1'){
                                             echo "<span class='badge badge-complete'><a style='color:white' href='brand.php?type=status&sts=".$row['brand_sts']."&cid=".$row['brand_id']."'>Active</a></span>";
                                          }else{
                                             echo "<span class='badge badge-pending'><a style='color:white' href='brand.php?type=status&sts=".$row['brand_sts']."&cid=".$row['brand_id']."'>Deactive</a></span>";
                                          }
                                       ?></td>
                                       <td class='edit'><span class='badge badge-complete'><a href='update_brand.php?bid=<?php echo $row['brand_id']; ?>'>Edit<i class='fa fa-edit'></i></a></span></td>
                                       <td class='delete'><span class='badge badge-pending'><a href='brand.php?type=delete&cid=<?php echo $row['brand_id']; ?>'>Delete</a></span></td>
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
if(isset($_SESSION['success_msg'])){
   echo '<div class="success_msg"><span>'.$_SESSION['success_msg'].'</span></div>';
?>
<script>
   jQuery('.success_msg').animate({top:"16%"},500);
   setTimeout(() => {
      jQuery('.success_msg').animate({top:"13%"},200);
   }, 500);
   setTimeout(() => {
      jQuery('.success_msg').animate({top:"16%"},200);
   }, 700);
   setTimeout(() => {
      jQuery('.success_msg').animate({top:"15%"},200);
   }, 900);
   setTimeout(() => {
      jQuery('.success_msg').animate({top:"16%"},200);
   }, 1100);
   setTimeout(() => {
      jQuery('.success_msg').animate({top:"-15%"},500);
   }, 2000);
</script>

<?php unset($_SESSION['success_msg']); } ?>
