<?php
   include "config.php";
   require('top.inc.php');
   if(isset($_GET['type'])){
    $type = $_GET['type'];
    if($type == 'status'){
       $slide_id =$_GET['sid'];
       if($_GET['sts']==1){
          $status = 0;
       }
       else{
          $status =1;
       }
 
    $updt_sql = "UPDATE slide_product SET slide_sts ={$status} WHERE slide_id ={$slide_id}";
    mysqli_query($conn,$updt_sql);
    }
    if($type=='delete'){
        $slide_id = $_GET['sid'];
  
        $dlt_sql = "DELETE FROM slide_product WHERE slide_id = {$slide_id}";
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
                           <h4 class="box-title">Slider Product </h4>
						   
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                              <?php   
                                 $sql = "SELECT * FROM slide_product
                                        LEFT JOIN product ON slide_product.product_id=product.product_id 
                                        LEFT JOIN category ON product.category = category.category_id
                                        LEFT JOIN sub_category ON product.sub_cat_id = sub_category.sub_id
                                        LEFT JOIN brand ON product.brand_id=brand.brand_id
                                        ORDER BY slide_product.slide_id DESC";
                                 $res = mysqli_query($conn,$sql) or die("Query Failed");
                              
                              ?>
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th>S.No</th>
                                       <th>Slider Id</th>
                                       <th>Product</th>
                                       <th>Category</th>
                                       <th>Brand</th>
                                       <th>Image</th>
                                       <th>Price</th>
                                       <th>Status</th>
                                       <th >Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                  <?php $i=1; while($row = mysqli_fetch_assoc($res)){ ?>
									    <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $row['slide_id']; ?></td>
                                            <td><?php echo $row['product_name']; ?></td>
                                            <td><?php echo $row['category_name']; ?></td>
                                            <td><?php echo $row['brand_name']; ?></td>
                                            <td class="avatar pb-0">
                                             <div class="round-img">
                                                <a href="#"><img class="rounded-circle" src="upload/<?php echo $row['img']; ?>" alt=""></a>
                                             </div>
                                            </td>
                                            <td><?php echo $row['price']." Tk"; ?></td>
                                            <td><?php
                                                if($row['slide_sts'] == '1'){
                                                    echo "<span class='badge badge-complete'><a style='color:white' href='slide_product.php?type=status&sts=".$row['slide_sts']."&sid=".$row['slide_id']."'>Active</a></span>";
                                                }else{
                                                    echo "<span class='badge badge-pending'><a style='color:white' href='slide_product.php?type=status&sts=".$row['slide_sts']."&sid=".$row['slide_id']."'>Deactive</a></span>";
                                                }
                                            ?></td>
                                            <td class='delete'><span class='badge badge-pending'><a href='slide_product.php?type=delete&sid=<?php echo $row['slide_id']; ?>'>Delete</a></span></td>
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