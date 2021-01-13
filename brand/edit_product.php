<?php
    ob_start();
    include "config.php";
    require('toper.php');
    $msg="";

    $username = $_SESSION['username'];
    $res_br = mysqli_query($conn,"SELECT * FROM brand WHERE user_name='{$username}'");
    if(mysqli_num_rows($res_br)>0){
      $row_br=mysqli_fetch_assoc($res_br);
    }
    if(isset($_POST['update'])){
        if(empty($_FILES['new-image']['name'])){
            $image_name = $_POST['old-image'];
          }
          else {
            $error = array();
        
            $file_name = $_FILES['new-image']['name'];
            $file_size = $_FILES['new-image']['size'];
            $file_tmp = $_FILES['new-image']['tmp_name'];
            $file_type = $_FILES['new-image']['type'];
            $file_ext = end(explode('.',$file_name));
            $extentions = array("jpeg","jpg","png");
        
            if(in_array($file_ext,$extentions) === false){
              $error[] = "This file extention are not allwed. Please choose a jpg or png file.";
            }
            if($file_size > 2097152){
              $error[]="File size must be 2mb or lower.";
            }
            $new_name = time()."-".basename($file_name);
            $target = "../admin/upload/".$new_name;
            $image_name = $new_name;

            if (empty($error)) {
              move_uploaded_file($file_tmp,$target);
            }
            else{
              print_r($error);
              die();
            }
          }


            $pdt_id =$_GET['pid'];
            $sql_updt = "UPDATE product SET product_name = '{$_POST['product_name']}',category = '{$_POST['category']}',sub_cat_id='{$_POST['sub_category']}',mrp = '{$_POST['mrp']}',price = '{$_POST['price']}',qty = '{$_POST['qty']}',long_desc = '{$_POST['desc']}',img='{$image_name}' 
                WHERE product_id = {$pdt_id};";
            if(mysqli_query($conn,$sql_updt)){
                header("Location: {$hostname}/product.php");
            }
            else{
                $msg ="Update Failed";
            }
    }
    if(isset($_GET['pid'])){
        $pid=$_GET['pid'];
        $res_edit = mysqli_query($conn,"SELECT * FROM product WHERE product_id={$pid}");
        if(mysqli_num_rows($res_edit)>0){
            $row_edit=mysqli_fetch_assoc($res_edit);
        }
    }
    else{
        header("location:{$hostname}/product.php");
    }

?>
<div class="content pb-0">
            <div class="add_content">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Product</strong><small> Form</small></div>
                          <div class="card-body card-block">
                          
                          <form  action="" method="POST" enctype="multipart/form-data">
                          <div class="form-group">
                          <label for="exampleInputPassword1">Category</label>
                          <select name="category" onchange="get_sub_cat('<?php echo $row_edit['sub_cat_id']; ?>')" id="cat_id" class="form-control">
                              <option > Select Category</option>
                              <?php
                                include "config.php";
                                $sql = "SELECT * FROM category";
                                $result = mysqli_query($conn,$sql) or die("Query Failed 2");
                                if(mysqli_num_rows($result) > 0){
                                  while ($row = mysqli_fetch_assoc($result)) {
                                    if($row['category_id']==$row_edit['category']){
                                      echo "<option value=".$row["category_id"]." selected>".$row['category_name']."</option>";
                                    }
                                    else{
                                      echo "<option value='{$row["category_id"]}' >{$row['category_name']}</option>";
                                    }
                                    
                                  }
                                }
                               ?>


                          </select>
                      </div>
                      <div class="form-group">
                        <label for="category" class=" form-control-label">Sub-Category</label>
                        <select name="sub_category" id="sub_cat_id" class="form-control">
                          <?php 
                              $res_sc=mysqli_query($conn,"SELECT * FROM sub_category WHERE category_id={$row_edit['category']} AND status=1");
                              if(mysqli_num_rows($res_sc)>0){
                                while($row_sc=mysqli_fetch_assoc($res_sc)){
                                    if($row_edit['sub_cat_id']==$row_sc['sub_id']){
                                        echo "<option value=".$row_sc["sub_id"]." selected>".$row_sc['sub_categories']."</option>";
                                    }
                                  echo "<option value=".$row_sc["sub_id"].">".$row_sc['sub_categories']."</option>";
                                }
                              }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Prodeuct Name</label>
                          <input type="text" name="product_name" value="<?php echo $row_edit['product_name']; ?>" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="post_title">MRP</label>
                          <input type="number" name="mrp" value="<?php echo $row_edit['mrp'];  ?>" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Price</label>
                          <input type="number" name="price" value="<?php echo $row_edit['price'];  ?>" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Quantity</label>
                          <input type="number" name="qty" value="<?php echo $row_edit['qty'];  ?>" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="desc" class="form-control" rows="5"  required><?php echo $row_edit['long_desc']; ?></textarea>
                      </div>
                      
                      <div class="form-group edit_img_site">
                          <label for="exampleInputPassword1">Post image</label><br>
                          <input type="file"  name="new-image">
                          <img  src="../admin/upload/<?php echo $row_edit['img']; ?>" height="150px">
                          <input type="hidden" name="old-image" value="<?php echo $row_edit['img']; ?>">
                      </div>
                      <input type="submit" name="update" class="btn btn-primary" value="Update" required />
                  </form>
                              <div class="result_msg"><?php echo $msg; ?></div>
                          </div>
                     </div>
                  </div>
               </div>
            </div>
    </div>
                  
<?php
require('footer.php');
?>