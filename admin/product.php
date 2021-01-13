<?php
   include "config.php";
   require('top.inc.php');
?>
<div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="box-title">Product Master </h4>
						   <h4 class="box_title_link " ><a href="add_product.php">Add Product</a> </h4>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                              <?php   
                                 $sql = "SELECT * FROM product 
                                        LEFT JOIN category ON product.category = category.category_id
                                        LEFT JOIN sub_category ON product.sub_cat_id = sub_category.sub_id
                                        LEFT JOIN brand ON product.brand_id=brand.brand_id
                                        ORDER BY product.product_id DESC";
                                 $res = mysqli_query($conn,$sql) or die("Query Failed");
                              
                              ?>
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th>S.No</th>
                                       <th>ID</th>
                                       <th>Name</th>
                                       <th>Category</th>
                                       <th>Sub-Category</th>
                                       <th>Brand</th>
                                       <th>Discount</th>
                                       <th>Quantity</th>
                                       <th>Image</th>
                                       <th>Price</th>
                                       <th>Coin Price</th>
                                       <th>Add to slide</th>
                                       <th colspan="2">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                  <?php $i=1; while($row = mysqli_fetch_assoc($res)){ ?>
									    <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $row['product_id']; ?></td>
                                            <td><?php echo $row['product_name']; ?></td>
                                            <td><?php echo $row['category_name']; ?></td>
                                            <td><?php echo $row['sub_categories']; ?></td>
                                            <td><?php echo $row['brand_name']; ?></td>
                                            <td><?php echo $row['discount']; ?>%</td>
                                            <td><?php echo $row['qty']; ?></td>
                                            <td class="avatar pb-0">
                                             <div class="round-img">
                                                <a href="#"><img class="rounded-circle" src="upload/<?php echo $row['img']; ?>" alt=""></a>
                                             </div>
                                            </td>
                                            <td><?php echo $row['price']." Tk"; ?></td>
                                            <td><?php
                                             if($row['coin']>=1000){
                                                echo number_format(($row['coin']/1000),1)."k";
                                             }else{
                                                echo $row['coin']; 
                                             }
                                            ?></td>
                                            <td><button class="slid_btn" onclick="slide_btn('<?php echo $row['product_id'];?>')">+Slide</button></td>
                                            <td class='edit'><span class='badge badge-complete'><a href='update-product.php?pid=<?php echo $row['product_id']; ?>'>Edit<i class='fa fa-edit'></i></a></span></td>
                                            <td class='delete'><span class='badge badge-pending' onclick="delete_product(<?php echo $row['product_id']; ?>)"><a href="#">Delete</a></span></td>
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
<?php  
if(isset($_SESSION['error_msg'])){
   echo '<div class="error_msg"><span>'.$_SESSION['error_msg'].'</span></div>';
?>
<script>
   jQuery('.error_msg').animate({top:"16%"},500);
   setTimeout(() => {
      jQuery('.error_msg').animate({top:"13%"},200);
   }, 500);
   setTimeout(() => {
      jQuery('.error_msg').animate({top:"16%"},200);
   }, 700);
   setTimeout(() => {
      jQuery('.error_msg').animate({top:"15%"},200);
   }, 900);
   setTimeout(() => {
      jQuery('.error_msg').animate({top:"16%"},200);
   }, 1100);
   setTimeout(() => {
      jQuery('.error_msg').animate({top:"-15%"},500);
   }, 2000);
</script>

<?php unset($_SESSION['error_msg']); } ?>