<?php
    ob_start();
    include "config.php";
    include "function.inc.php";
    require('top.inc.php');
    $msg="";
    if(isset($_POST['submit'])){
        if(isset($_FILES['fileToUpload'])){
            $error = array();
        
            $file_name = $_FILES['fileToUpload']['name'];
            $file_size = $_FILES['fileToUpload']['size'];
            $file_tmp = $_FILES['fileToUpload']['tmp_name'];
            $file_type = $_FILES['fileToUpload']['type'];
            $expld =explode('.',$file_name);
            $file_ext = end($expld);
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


          $pdt_name = get_string($conn,$_POST['product_name']);
          $cat_name = get_string($conn,$_POST['category']);
          $sub_cat = get_string($conn,$_POST['sub_category']);
          $price = get_string($conn,$_POST['price']);
          $coin = get_string($conn,$_POST['coin']);
          if($coin==''){
            $coin=0;
          }
          $qty= get_string($conn,$_POST['qty']);
          $desc=get_string($conn,$_POST['desc']);
          $brand = get_string($conn,$_POST['brand']);
          $discount=get_string($conn,$_POST['discount']);
          if($discount==''){
            $discount=0;
          }
            $sql_insrt = "INSERT INTO product(product_name,category,price,coin,qty,long_desc,img,sub_cat_id,brand_id,discount,pdt_sts)
                VALUES('{$pdt_name}','{$cat_name}','{$price}',{$coin},'{$qty}','{$desc}','{$image_name}','{$sub_cat}',{$brand},{$discount},1)";
            if(mysqli_query($conn,$sql_insrt)){
                header("Location: {$hostname}/admin/product.php");
                ob_end_flush();
            }
            else{
                $msg ="Insertation Failed";
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
                          <form  action="" method="POST" enctype="multipart/form-data">
                          <div class="form-group">
                          <label for="exampleInputPassword1">Category</label>
                          <select name="category" onchange="get_sub_cat()" id="cat_id" class="form-control">
                              <option > Select Category</option>
                              <?php
                                include "config.php";
                                $sql = "SELECT * FROM category";
                                $result = mysqli_query($conn,$sql) or die("Query Failed 2");
                                if(mysqli_num_rows($result) > 0){
                                  while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row["category_id"]}' >{$row['category_name']}</option>";
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
                                    echo '<option value='.$row_b['brand_id'].'>'.$row_b['brand_name'].'</option>';
                                  }
                                }
                              
                              ?>
                        </select>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Prodeuct Name</label>
                          <input type="text" name="product_name" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Price</label>
                          <input type="number" name="price" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Coin Price</label>
                          <input type="number" name="coin" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Quantity</label>
                          <input type="number" name="qty" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Discount</label>
                          <input type="number" name="discount" class="form-control" autocomplete="off" placeholder="Enter Percentage(%) of Discount" >
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="desc" class="form-control" rows="5"  required></textarea>
                      </div>
                      
                      <div class="form-group">
                          <label for="exampleInputPassword1">Post image</label><br>
                          <input type="file" name="fileToUpload" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
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