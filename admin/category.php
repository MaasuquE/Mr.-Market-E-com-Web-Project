<?php
   include "config.php";
   require('top.inc.php');
   if(isset($_GET['type'])){
      $type = $_GET['type'];
      if($type == 'status'){
         $cat_id =$_GET['cid'];
         if($_GET['sts']==1){
            $status = 0;
         }
         else{
            $status =1;
         }
   
      $updt_sql = "UPDATE category SET status ={$status} WHERE category_id ={$cat_id};";
      mysqli_query($conn,$updt_sql);
      }
   
      if($type=='delete'){
         $cat_id = $_GET['cid'];
   
         $dlt_sql = "DELETE FROM category WHERE category_id = {$cat_id}";
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
                           <h4 class="box-title">Category Master </h4>
						   <h4 class="box_title_link " ><a href="add_category.php">Add Category</a> </h4>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                              <?php   
                                 $sql = "SELECT * FROM category ORDER BY category_id DESC";
                                 $res = mysqli_query($conn,$sql) or die("Query Failed");
                              
                              ?>
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th>S.No</th>
                                       <th>ID</th>
                                       <th>Category Name</th>
                                       <th>Status</th>
                                       <th>Edit</th>
                                       <th>Delete</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                  <?php $i=1; while($row = mysqli_fetch_assoc($res)){ ?>
									         <tr>
                                       <td><?php echo $i++; ?></td>
                                       <td><?php echo $row['category_id']; ?></td>
									            <td><?php echo $row['category_name']; ?></td>
                                       <td><?php
                                          if($row['status'] == '1'){
                                             echo "<span class='badge badge-complete'><a style='color:white' href='category.php?type=status&sts=".$row['status']."&cid=".$row['category_id']."'>Active</a></span>";
                                          }else{
                                             echo "<span class='badge badge-pending'><a style='color:white' href='category.php?type=status&sts=".$row['status']."&cid=".$row['category_id']."'>Deactive</a></span>";
                                          }
                                       ?></td>
                                       <td class='edit'><span class='badge badge-complete'><a href='update-category.php?cid=<?php echo $row['category_id']; ?>'>Edit<i class='fa fa-edit'></i></a></span></td>
                                       <td class='delete'><span class='badge badge-pending'><a href='category.php?type=delete&cid=<?php echo $row['category_id']; ?>'>Delete</a></span></td>
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
