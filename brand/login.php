<?php 

include "config.php";
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Brand</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/all.min.css">
  <link rel="stylesheet" href="css/fontawesome.min.css">
  
</head>
<body>

<?php if(isset($_GET['rt'])){ ?>
  <div class="register_text">
      <span>You will recived confimation messege on your mail.<br>Please wait for confirm.<span>
        <img src="../images/favicon.ico" alt="">
  </div>
<?php die(); }  ?>

  <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="login" id="login">
            <h1>Brand Login</h1>
              <form method="post">
                  <input type="text" id="login_username" placeholder="Username" required="required" />
                  <span id="field_error" class="log_user_err"></span>
                  <input type="password" id="login_password" placeholder="Password" required="required" />
                  <span id="field_error" class="log_pass_err"></span>
                  <button type="button" onclick="login_form()" class="btn btn-primary btn-block btn-large">Login</button>
              </form>
                <div class='register_link'>
                  Not a member?<span onclick="register_form()">Register Now</span>
                </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="register_form" id="register">
              <h3>Brand Register</h3>
                <form method="post">
                    <input type="text"  id="username" placeholder="Username" required="required" />
                    <span id="field_error" class="username_err"></span>
                    <input type="email" id="reg_email" placeholder="Email" required="required" />
                    <span id="field_error" class="email_err"></span>
                    <input type="text" id="brand_name" placeholder="Brand Name" required="required" />
                    <span id="field_error" class="brand_err"></span>
                    <div class="row reg_select">
                      <div class="col-md-6">
                          <select class="brand_cat" id="brand_cat">
                            <option value="" disabled selected> Brand Category</option>
                            <?php 
                            $res_cat=mysqli_query($conn,"SELECT * FROM category WHERE category_name!='men' AND category_name!='women'");
                            if(mysqli_num_rows($res_cat)>0){
                              while($row_cat=mysqli_fetch_assoc($res_cat)){
                                echo '<option value="'.$row_cat['category_id'].'">'.$row_cat['category_name'].'</option>';
                              }
                            }
                            ?>
                          </select>
                          <span id="field_error" class="cat_err"></span>
                      </div>
                      <div class="col-md-6">
                        <select class="city" id="city">
                          <option disabled selected>Select City</option>
                          <option >Sylhet</option>
                          <option>Dhaka</option>
                          <option>Sunamganj</option>
                          <option>Khulna</option>
                        </select>
                        <span id="field_error" class="city_err"></span>
                      </div>
                    </div>
                    
                    
                    <input type="number" id="licence" placeholder="Shop Licence Number" required="required" />
                    <span id="field_error" class="licence_err"></span>
                    <input type="text" id="address" placeholder="Address" required="required" />
                    <span id="field_error" class="address_err"></span>
                    <input type="password" id="password" placeholder="password" required="required" />
                    <span id="field_error" class="pass_err"></span>
                    <span class="logo_text">Logo</span><input type="file" onchange="brand_logo()" name="file" id="logo_file">
                    <span id="field_error" class="logo_err"></span>
                    <button type="button" onclick="register_btn()" class="btn btn-primary btn-block btn-large">Submit</button><br>
                    
                </form>
            </div>
          </div>
        </div>
      </div>  
  </div>
  <script src="js/vendor/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/custom.js"></script>
</body>
</html>