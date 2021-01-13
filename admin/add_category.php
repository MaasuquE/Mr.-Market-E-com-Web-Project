<?php
    include "config.php";
    include "function.inc.php";
    require('top.inc.php');
    $msg="";
    if(isset($_POST['submit'])){
        $cat_name = get_string($conn,$_POST['category']);
        $sql ="SELECT * FROM category WHERE category_name ='{$cat_name}';";
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){
            $msg ="This Category already exist please try another";
        }
        else{
            $sql_insrt = "INSERT INTO category(category_name,status) VALUES('{$cat_name}','1');";
            if(mysqli_query($conn,$sql_insrt)){
                header("Location: {$hostname}/admin/category.php");
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
								<input type="text" name="category" placeholder="Enter your category name" class="form-control" required>
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