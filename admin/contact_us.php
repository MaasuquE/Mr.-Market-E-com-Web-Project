<?php
   include "config.php";
   require('top.inc.php');
   if(isset($_GET['id'])){
      $cnt_id = $_GET['id'];

      $sql_dlt = "DELETE FROM contact_us WHERE contact_id ={$cnt_id}";
      mysqli_query($conn,$sql_dlt);
   }
?>
<div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="box-title">Contact Us </h4>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                              <?php   
                                 $sql = "SELECT * FROM contact_us";
                                 $res = mysqli_query($conn,$sql) or die("Query Failed");
                              
                              ?>
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th>S.No</th>
                                       <th>ID</th>
                                       <th>Name</th>
                                       <th>Email</th>
                                       <th>Mobile</th>
                                       <th>Query</th>
                                       <th>Address</th>
                                       <th>Date</th>
                                       <th></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                  <?php $i=1; while($row = mysqli_fetch_assoc($res)){ ?>
									         <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $row['contact_id']; ?></td>
                                       <td><?php echo $row['name']; ?></td>
                                       <td><?php echo $row['email']; ?></td>
                                       <td><?php echo $row['mobile']; ?></td>
                                       <td><?php echo $row['comment']; ?></td>
                                       <td><?php echo $row['address']; ?></td>
                                       <td><?php echo $row['added_on']; ?></td>
                                       <td class='delete'><span class='badge badge-pending'><a href='contact_us.php?id=<?php echo $row['contact_id']; ?>'>Delete</a></span></td>
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