<?php
    ob_start();
    include "config.php";
    require('top.inc.php');
    $msg="";
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
            $target = "upload/".$new_name;
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
            $sql_updt = "UPDATE product SET product_name = '{$_POST['product_name']}',category = '{$_POST['category']}',sub_cat_id='{$_POST['sub_category']}',mrp = '{$_POST['mrp']}',price = '{$_POST['price']}',qty = '{$_POST['qty']}',long_desc = '{$_POST['desc']}',coin = '{$_POST['coin']}',img='{$image_name}',brand_id={$_POST['brand']} 
                WHERE product_id = {$pdt_id};";
            if(mysqli_query($conn,$sql_updt)){
                header("Location: {$hostname}/admin/product.php");
                ob_end_flush();
            }
            else{
                $msg ="Update Failed";
            }
    }
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Product</strong><small> Form</small></div>
                          <div class="card-body card-block">
                          <?php 
                                $pdt_id = $_GET['pid'];

                                $sql1 = "SELECT * FROM product WHERE product_id ={$pdt_id}";
                                $res1 = mysqli_query($conn,$sql1);
                                if(mysqli_num_rows($res1) > 0){
                                    while($row1=mysqli_fetch_assoc($res1)){ 

                          ?>
                          <form  action="" method="POST" enctype="multipart/form-data">
                          <div class="form-group">
                          <label for="exampleInputPassword1">Category</label>
                          <select name="category" onchange="get_sub_cat()" id="cat_id" class="form-control">
                              <option disabled> Select Category</option>
                              <?php
                                include "config.php";
                                $sql = "SELECT * FROM category";
                                $result = mysqli_query($conn,$sql) or die("Query Failed 2");
                                if(mysqli_num_rows($result) > 0){
                                  while ($row = mysqli_fetch_assoc($result)) {
                                    if($row['category_id']==$row1['category']){
                                      $selected ="selected";
                                    }
                                    else{
                                      $selected ="";
                                    }
                                    echo "<option {$selected} value='{$row["category_id"]}' >{$row['category_name']}</option>";
                                  }
                                }
                               ?>


                          </select>
                      </div>
                      <div class="form-group">
                        <label for="category" class=" form-control-label">Sub-Category</label>
                        <select name="sub_category" id="sub_cat_id" class="form-control">
                          <option>Select Sub-Category</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="category" class=" form-control-label">Brand</label>
                        <select name="brand" class="form-control">
                              <?php 
                                $res_b=mysqli_query($conn,"SELECT * FROM brand");
                                if(mysqli_num_rows($res_b)>0){
                                  while($row_b=mysqli_fetch_assoc($res_b)){
                                    if($row_b['brand_id']==$row1['brand_id']){
                                      echo '<option value='.$row_b['brand_id'].' selected>'.$row_b['brand_name'].'</option>';
                                    }
                                    else{
                                      echo '<option value='.$row_b['brand_id'].'>'.$row_b['brand_name'].'</option>';
                                    }
                                    
                                  }
                                }
                              
                              ?>
                        </select>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Prodeuct Name</label>
                          <input type="text" name="product_name" value="<?php echo $row1['product_name']; ?>" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="post_title">MRP</label>
                          <input type="number" name="mrp" value="<?php echo $row1['mrp']; ?>" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Price</label>
                          <input type="number" name="price" value="<?php echo $row1['price']; ?>" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Coin Price</label>
                          <input type="number" name="coin" value="<?php echo $row1['coin']; ?>" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Quantity</label>
                          <input type="number" name="qty" value="<?php echo $row1['qty']; ?>" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="desc"  class="form-control"   required><?php echo $row1['long_desc']; ?></textarea>
                      </div>
                      
                      <div class="form-group">
                          <label for="exampleInputPassword1">Post image</label><br>
                          <input type="file" name="new-image">
                          <img  src="upload/<?php echo $row1['img']; ?>" height="150px">
                          <input type="hidden" name="old-image" value="<?php echo $row1['img']; ?>">
                      </div>
                      <input type="submit" name="update" class="btn btn-primary" value="Update" required />
                    </form>
                    <?php  
                            }
                        }
                    ?>
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

<script>
<?php 
  if(isset($_GET['pid'])){
    $pdt_id = $_GET['pid'];
    $sub_cat_id ='';
    $sql_sb = "SELECT * FROM product WHERE product_id ={$pdt_id}";
    $res_sb = mysqli_query($conn,$sql_sb);
    if(mysqli_num_rows($res_sb) > 0){
      $row=mysqli_fetch_assoc($res_sb);
      $sub_cat_id=$row['sub_cat_id'];
    }?>
    get_sub_cat('<?php echo $sub_cat_id ?>');

  <?php  } ?>
</script>