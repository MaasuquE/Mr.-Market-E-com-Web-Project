<?php
    ob_start();
    include "config.php";
    include "function.inc.php";
    require('top.inc.php');
    $msg="";
    $user_err="";
    $email_err="";
    $brand_err="";
    $err="";
    if(isset($_GET['bid'])){
        $brand_id =$_GET['bid'];
    }
    else{
        header("location:{$hostname}/admin/brand.php");
    }
    date_default_timezone_set("Asia/Dhaka");
    if(isset($_POST['submit'])){
          $city_sql="";
          $brand_name = get_string($conn,$_POST['brand_name']);
          $cat_id = get_string($conn,$_POST['category']);
          $username = get_string($conn,$_POST['user_name']);
          $email = get_string($conn,$_POST['email']);
          $phone = get_string($conn,$_POST['phone']);
          $city= get_string($conn,$_POST['city']);
          if($city!=''){
            $city_sql = ",city= '{$city}'";
          }
          $licence=get_string($conn,$_POST['licence']);
          $address=get_string($conn,$_POST['address']);
          $password=get_string($conn,$_POST['password']);
          $date =date("Y-m-d h:i:sa");
        $res_qry =mysqli_query($conn,"SELECT * FROM brand WHERE brand_id!={$brand_id}");
          if(mysqli_num_rows($res_qry)>0){
            
            while($row_qry=mysqli_fetch_assoc($res_qry)){
              if($row_qry['user_name']==$username){
                $user_err ="Username Alreday exist.";
                $err='yes';
              }
              if($row_qry['email']==$email){
                $email_err="Email already exist.";
                $err='yes';
              }
              if($row_qry['city']==$city && $row_qry['brand_name']==$brand_name){
                if($row_qry['address']==$address){
                  $brand_err="This brand already exits with same loction";
                  $err='yes';
                }
              }
            }
          }
          if($err==''){
            $sql_updt = "UPDATE brand SET brand_name = '{$brand_name}',user_name= '{$username}',brand_cat= {$cat_id},email= '{$email}',phone= '{$phone}'{$city_sql},licence= '{$licence}',address= '{$address}',password= '{$password}'
                WHERE brand_id={$brand_id}";
            if(mysqli_query($conn,$sql_updt)){
                $_SESSION['success_msg']="Id-{$brand_id} Update Successfully!";
                header("Location: {$hostname}/admin/brand.php");
                ob_end_flush();
            }
            else{
                $msg ="Update Failed";
            }
          }

          
    }
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Update Brand</strong></div>
                          <div class="card-body card-block">
                          <?php  
                            $brand_id =$_GET['bid'];
                            $res_updt = mysqli_query($conn,"SELECT * FROM brand WHERE brand_id={$brand_id}");
                            if(mysqli_num_rows($res_updt)>0){
                                $row_updt=mysqli_fetch_assoc($res_updt);
                            }
                            
                            ?>
                          <form  action="" method="POST" enctype="multipart/form-data">
                          <div class="form-group">
                          <label for="exampleInputPassword1">Select Category</label>
                          <select name="category" class="form-control" >
                              <!-- <option > Select Category</option> -->
                              <?php
                                include "config.php";
                                $sql = "SELECT * FROM category";
                                $result = mysqli_query($conn,$sql) or die("Query Failed 2");
                                if(mysqli_num_rows($result) > 0){
                                  while ($row = mysqli_fetch_assoc($result)) {
                                      if($row_updt['brand_cat']==$row['category_id']){
                                        echo "<option value=".$row['category_id']." selected>".$row['category_name']."</option>";
                                      }
                                      else{
                                        echo "<option value=".$row['category_id']." >".$row['category_name']."</option>";
                                      }
                                    
                                  }
                                }
                               ?>

                          </select>
                      </div>
                     
                      <div class="form-group">
                          <label for="post_title">Brand Name</label>
                          <input type="text" name="brand_name" value="<?php echo $row_updt['brand_name']; ?>" class="form-control" autocomplete="off" required>
                          <span class="field_error"><?php echo $brand_err; ?></span>
                      </div>
                      <div class="form-group">
                          <label for="post_title">User Name</label>
                          <input type="text" name="user_name" value="<?php echo $row_updt['user_name']; ?>" class="form-control" autocomplete="off" required>
                          <span class="field_error"><?php echo $user_err; ?></span>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Email</label>
                          <input type="email" name="email" value="<?php echo $row_updt['email']; ?>" class="form-control" autocomplete="off" required>
                          <span class="field_error" ><?php echo $email_err; ?></span>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Phone Number</label>
                          <input type="number" name="phone" value="<?php echo $row_updt['phone']; ?>" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="post_title">City</label>
                          <select  name="city" class="form-control" >
                              <option value="<?php echo $row_updt['city']; ?>" disabled selected><?php echo $row_updt['city']; ?></option>
                            <option >Sylhet</option>
                            <option>Dhaka</option>
                            <option>Sunamganj</option>
                            <option>Khulna</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Shop Licence</label>
                          <input type="text" name="licence" value="<?php echo $row_updt['licence']; ?>"  class="form-control" autocomplete="off" required>
                      </div>
                      <!-- <div class="form-group">
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="desc" class="form-control" rows="5"  required></textarea>
                      </div> -->
                      <div class="form-group">
                          <label for="post_title">Address</label>
                          <input type="text" name="address" value="<?php echo $row_updt['address']; ?>" class="form-control" autocomplete="off" required>
                          <span class="field_error"><?php echo $brand_err; ?></span>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Password</label>
                          <input type="password" name="password" value="<?php echo $row_updt['password']; ?>" class="form-control" autocomplete="off" required>
                      </div>
                      <!-- <div class="form-group">
                          <label for="exampleInputPassword1">Post image</label><br>
                          <input type="file" name="fileToUpload" required>
                      </div> -->
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
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