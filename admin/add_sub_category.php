<?php
    include "config.php";
    include "function.inc.php";
    require('top.inc.php');
    $msg="";
    if(isset($_POST['submit'])){
        $cat_id = $_POST['category'];
        $sub_cat = get_string($conn,$_POST['sub_category']);
        $sql ="SELECT * FROM sub_category WHERE sub_categories='{$sub_cat}' AND category_id ={$cat_id};";
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){
            $msg ="This Category already exist please try another";
        }
        else{
            $sql_insrt = "INSERT INTO sub_category(category_id,sub_categories,status) VALUES({$cat_id},'{$sub_cat}','1');";
            if(mysqli_query($conn,$sql_insrt)){
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
                                    echo "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
                                  }
                                }
                               ?>


                                </select>
                               </div>
                               <div class="form-group">
								<label for="category" class=" form-control-label">Sub-Category Name</label>
								<input type="text" name="sub_category" placeholder="Enter your category name" class="form-control" required>
                               </div>
							   
							   <button  type="submit" name="submit" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount">Submit</span>
							   </button>
							  </form>
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