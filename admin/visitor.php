<?php
   include "config.php";
   require('top.inc.php');
   if(isset($_GET['type'])){
      $type = $_GET['type'];
   
      if($type=='delete'){
         $user_id = $_GET['uid'];
   
         $dlt_sql = "DELETE FROM user WHERE id = {$user_id}";
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
                           <h4 class="box-title">Visitor Table </h4>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                              <?php   
                                 $sql = "SELECT * FROM visitor";
                                 $res = mysqli_query($conn,$sql) or die("Query Failed");
                              
                              ?>
                              <table class="table" id ="myTable">
                                 <thead>
                                    <tr>
                                       <th>S.No</th>
                                       <th>ID</th>
                                       <th>Ip Address</th>
                                       <th>Date</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                  <?php $i=1; while($row = mysqli_fetch_assoc($res)){ ?>
									         <tr>
                                       <td><?php echo $i++; ?></td>
                                       <td><?php echo $row['visitor_id']; ?></td>
                                       <td><?php echo $row['ip_address']; ?></td>
                                       <td><?php echo $row['visiting_date']; ?></td>
                                       <td ><button type="button" id="dlt_btn" onclick="delete_btn(this,'<?php echo $row['id']; ?>')" data-id="<?php echo $row['id']; ?>">Delete</button></td>
                                       
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