<?php
    include "config.php";
    include "function.inc.php";
    require('top.inc.php');
    $msg="";
    if(isset($_POST['update'])){
        $sub_id =$_GET['cid'];
        $cat_id = $_POST['category'];
        $sub_cat = get_string($conn,$_POST['sub_category']);
        $sql ="SELECT * FROM sub_category WHERE sub_categories='{$sub_cat}' AND category_id ={$cat_id};";
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){
            $msg ="This Category already exist please try another";
        }
        else{
            $sql_updt = "UPDATE sub_category SET category_id={$cat_id},sub_categories='{$sub_cat}' WHERE sub_id={$sub_id};";
            if(mysqli_query($conn,$sql_updt)){
                header("Location: {$hostname}/admin/sub_category.php");
            }
            else{
                $msg ="Insertation Failed";
            }
        }
    }
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Categories</strong><small> Form</small></div>
                          <div class="card-body card-block">
                          <?php   
                            $sub_id = $_GET['cid'];
                            $sql2 = "SELECT * FROM sub_category WHERE sub_id={$sub_id};";
                            $res2 = mysqli_query($conn,$sql2);
                            while($row2=mysqli_fetch_assoc($res2)){
                          
                          ?>
                           <form method="post">
							   <div class="form-group">
								<label for="category" class=" form-control-label">Category Name</label>
								<select name="category" class="form-control">
                              <option disabled> Select Category</option>
                              <?php
                                include "config.php";
                                $sql = "SELECT * FROM category";
                                $result = mysqli_query($conn,$sql) or die("Query Failed 2");
                                if(mysqli_num_rows($result) > 0){
                                  while ($row = mysqli_fetch_assoc($result)) {
                                    if($row['category_id']==$row2['category_id']){
                                        $selected = "selected";
                                    }
                                    else{
                                        $selected="";
                                    }
                                    echo "<option value='{$row['category_id']}' {$selected}>{$row['category_name']}</option>";
                                  }
                                }
                               ?>


                                </select>
                               </div>
                               <div class="form-group">
								<label for="category" class=" form-control-label">Sub-Category Name</label>
								<input type="text" name="sub_category" placeholder="Enter your category name" value="<?php echo $row2['sub_categories'];  ?>" class="form-control" required>
                               </div>
							   
							   <button  type="submit" name="update" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount">Update</span>
							   </button>
							  </form>
                            <?php } ?>
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