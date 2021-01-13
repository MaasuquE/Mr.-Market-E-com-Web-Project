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
   
         $dlt_sql = "DELETE FROM sub_category WHERE sub_id = {$cat_id}";
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
                           <h4 class="box-title">Sub Category Master </h4>
						   <h4 class="box_title_link " ><a href="add_sub_category.php">Add Sub-Category</a> </h4>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                              <?php   
                                 $sql = "SELECT * FROM sub_category JOIN category ON sub_category.category_id=category.category_id ORDER BY sub_id DESC";
                                 $res = mysqli_query($conn,$sql) or die("Query Failed");
                              
                              ?>
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th>S.No</th>
                                       <th>ID</th>
                                       <th>Category Name</th>
                                       <th>Sub Category</th>
                                       <th>Status</th>
                                       <th>Edit</th>
                                       <th>Delete</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                  <?php $i=1; while($row = mysqli_fetch_assoc($res)){ ?>
									         <tr>
                                       <td><?php echo $i++; ?></td>
                                       <td><?php echo $row['sub_id']; ?></td>
									            <td><?php echo $row['category_name']; ?></td>
									            <td><?php echo $row['sub_categories']; ?></td>
                                       <td><?php
                                          if($row['status'] == '1'){
                                             echo "<span class='badge badge-complete'><a style='color:white' href='sub_category.php?type=status&sts=".$row['status']."&cid=".$row['category_id']."'>Active</a></span>";
                                          }else{
                                             echo "<span class='badge badge-pending'><a style='color:white' href='sub_category.php?type=status&sts=".$row['status']."&cid=".$row['category_id']."'>Deactive</a></span>";
                                          }
                                       ?></td>
                                       <td class='edit'><span class='badge badge-complete'><a href='update-sub_category.php?cid=<?php echo $row['sub_id']; ?>'>Edit<i class='fa fa-edit'></i></a></span></td>
                                       <td class='delete'><span class='badge badge-pending'><a href='sub_category.php?type=delete&cid=<?php echo $row['sub_id']; ?>'>Delete</a></span></td>
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