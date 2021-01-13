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
    date_default_timezone_set("Asia/Dhaka");
    if(isset($_POST['submit'])){
        if(isset($_FILES['fileToUpload'])){
            $error = array();
        
            $file_name = $_FILES['fileToUpload']['name'];
            $file_size = $_FILES['fileToUpload']['size'];
            $file_tmp = $_FILES['fileToUpload']['tmp_name'];
            $file_type = $_FILES['fileToUpload']['type'];
            $expld=explode('.',$file_name);
            $file_ext = end($expld);
            $extentions = array("jpeg","jpg","png");
        
            if(in_array($file_ext,$extentions) === false){
              $error[] = "This file extention are not allwed. Please choose a jpg or png file.";
            }
            if($file_size > 2097152){
              $error[]="File size must be 2mb or lower.";
            }
            $new_name = time()."-".basename($file_name);
            $target = "../brand/upload/".$new_name;
            $image_name = $new_name;

            if (empty($error)) {
              move_uploaded_file($file_tmp,$target);
              
            }
            else{
              print_r($error);
              die();
            }
          }


          $brand_name = get_string($conn,$_POST['brand_name']);
          $cat_id = get_string($conn,$_POST['category']);
          $username = get_string($conn,$_POST['user_name']);
          $email = get_string($conn,$_POST['email']);
          $phone = get_string($conn,$_POST['phone']);
          $city= get_string($conn,$_POST['city']);
          $licence=get_string($conn,$_POST['licence']);
          $address=get_string($conn,$_POST['address']);
          $password=get_string($conn,$_POST['password']);
          $date =date("Y-m-d h:i:sa");

          $res_qry =mysqli_query($conn,"SELECT * FROM brand");
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
            $sql_insrt = "INSERT INTO brand(brand_name,user_name,brand_cat,email,phone,city,licence,address,password,added_on,brand_logo,brand_sts)
                VALUES('{$brand_name}','{$username}',{$cat_id},'{$email}','{$phone}','{$city}','{$licence}','{$address}','{$password}','{$date}','{$image_name}',1)";
                
            if(mysqli_query($conn,$sql_insrt)){
                $_SESSION['success_msg']="Insert Successfully!";
                header("Location: {$hostname}/admin/brand.php");
                ob_end_flush();
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
                        <div class="card-header"><strong>Add Brand</strong><small> Form</small></div>
                          <div class="card-body card-block">
                           
                        <form  action="" method="POST" enctype="multipart/form-data">
                          <div class="form-group">
                          <label for="exampleInputPassword1">Select Category</label>
                          <select name="category" onchange="get_sub_cat()" id="cat_id" class="form-control" >
                              <!-- <option > Select Category</option> -->
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
                          <label for="post_title">Brand Name</label>
                          <input type="text" name="brand_name" class="form-control" autocomplete="off" required>
                          <span class="field_error"><?php echo $brand_err; ?></span>
                      </div>
                      <div class="form-group">
                          <label for="post_title">User Name</label>
                          <input type="text" name="user_name" class="form-control" autocomplete="off" required>
                          <span class="field_error"><?php echo $user_err; ?></span>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Email</label>
                          <input type="email" name="email" class="form-control" autocomplete="off" required>
                          <span class="field_error" ><?php echo $email_err; ?></span>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Phone Number</label>
                          <input type="number" name="phone" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="post_title">City</label>
                          <select  name="city" class="form-control" >
                            <option selected>Sylhet</option>
                            <option>Dhaka</option>
                            <option>Sunamganj</option>
                            <option>Khulna</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Shop Licence</label>
                          <input type="text" name="licence" class="form-control" autocomplete="off" required>
                      </div>
                      <!-- <div class="form-group">
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="desc" class="form-control" rows="5"  required></textarea>
                      </div> -->
                      <div class="form-group">
                          <label for="post_title">Address</label>
                          <input type="text" name="address" class="form-control" autocomplete="off" required>
                          <span class="field_error"><?php echo $brand_err; ?></span>
                      </div>
                      <div class="form-group">
                          <label for="post_title">Password</label>
                          <input type="password" name="password" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Logo image</label><br>
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