<?php
    include "config.php";
    require('top.inc.php');
    $msg="";
    if(isset($_POST['update'])){
        $cat_id = $_GET['cid'];
        $cat_name = $_POST['category'];
        $sql_updt ="UPDATE category SET category_name = '{$cat_name}' WHERE category_id = {$cat_id};";
        if(mysqli_query($conn,$sql_updt)){
            header("Location: {$hostname}/admin/category.php");
        }
        else{
            $msg = "Update Failed";
        }
    }
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Update Category</strong></div>
                          <div class="card-body card-block">
                          <?php 
                            if(isset($_GET['cid'])){
                                $cat_id = $_GET['cid'];
                            }
                            $sql = "SELECT * FROM category WHERE category_id = {$cat_id};";
                            $res = mysqli_query($conn,$sql) or die("Query Failed");
                            if(mysqli_num_rows($res)){
                                while($row = mysqli_fetch_assoc($res)){
                          
                          ?>
                           <form method="post">
							   <div class="form-group">
								<label for="category" class=" form-control-label">Category Name</label>
								<input type="text" name="category" value="<?php echo $row['category_name']; ?>" placeholder="Enter your category name" class="form-control" required>
                               </div>
							   
							   <button  type="submit" name="update" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount">Update</span>
							   </button>
							  </form>
                             <?php }
                                } ?>
                              <div class="result_msg"><?php echo $msg; ?></div>
                          </div>
                     </div>
                  </div>
               </div>
            </div>
    </div>
                  
<?php
require('footer.inc.php');
?>