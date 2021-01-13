<?php  
ob_start();
include "config.php";
include "toper.php";
if(!isset($_SESSION['USER_LOGIN'])){
    $_SESSION['checkout']='yes';
    header("Location:{$hostname}/login.php");
    ob_end_flush();
  }
  $user_id=$_SESSION['user_id'];
  $sql="SELECT * FROM user WHERE id={$user_id}";
    $res=mysqli_query($conn,$sql);
    if(mysqli_num_rows($res) >0){
        $row=mysqli_fetch_assoc($res);
    }

  if(empty($_FILES['new-image']['name'])){
    $image_name = $row['img'];
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
    $target = "admin/upload/".$new_name;
    $image_name = $new_name;

    if (empty($error)) {
      move_uploaded_file($file_tmp,$target);
    }
    else{
      print_r($error);
      die();
    }
    
  } 
    
?>
<link rel="stylesheet" href="css/profile.css">
<div class="container emp-profile">
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img id="img" src="admin/upload/<?php echo $row['img']; ?>" alt=""/>
                            <div class="file btn btn-lg btn-primary">
                                Change Photo
                                <input type="file" id="file" onchange="file_change('<?php echo $user_id; ?>')" name="new-image">
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                        <?php echo $row['name']; ?>
                                    </h5>
                                    <h6>
                                        Customer
                                    </h6>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item active">
                                    <a class="active nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                                <li class="nav-item no_ac">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Timeline</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2 profile-edit-btn">
                        <input type="button" onclick="update_profile('<?php echo $user_id; ?>','<?php echo $image_name; ?>')" name="update" value="Update Profile"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <!-- <div class="profile-work">
                            <p>WORK LINK</p>
                            <a href="#home">Website Link</a><br/>
                            <a href="#home">Bootsnipp Profile</a><br/>
                            <a href="#home">Bootply Profile</a>
                            <p>SKILLS</p>
                            <a href="#profile">Web Designer</a><br/>
                            <a href="#profile">Web Developer</a><br/>
                            <a href="#profile">WordPress</a><br/>
                            <a href="#profile">WooCommerce</a><br/>
                            <a href="#profile">PHP, .Net</a><br/>
                        </div> -->
                    </div>
                    <div class="col-md-8 body_info">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            <div class="row">
                                                <div class="col-md-6" >
                                                    <label>Name</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" id="name" placeholder="Enter name...." value="<?php echo $row['name'];?>" required/>
                                                    <br><span class="field_error" id="name_error"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Email</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="email" id="email" value="<?php echo $row['email'];?>" placeholder="Enter email...." required/>
                                                    <br><span class="field_error" id="email_error"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Phone</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" id="phn" value="<?php echo $row['mobile'];?>" placeholder="Enter mobile number...." required/>
                                                    <br><span class="field_error" id="phn_error"></span>
                                                </div>
                                            </div>
                                            <div class="row pass_btn">
                                                <div class="col-md-6">
                                                    <label>Password</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button"  onclick="chage_pass()">Change Password</button>
                                                </div>
                                            </div>
                                </div>
                            </div>
                            <div class="pass_change profile-tab" id="change_pass">
                                <div class="row">
                                    <div class="col-md-6" >
                                        <label>Old Password</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" id="old_pass" value="" placeholder="Enter old password..." required/>
                                        <br><span class="field_error" id="old_pass_error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" >
                                        <label>New Password</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" id="new_pass1" value="" placeholder="Enter new password..." required/>
                                        <br><span class="field_error" id="pass1_error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" >
                                        <label>Confirm Password</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" id="new_pass2" placeholder="Enter new password...." required/>
                                        <br><span class="field_error" id="pass2_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>           
        </div>
<?php   
    include "footer.php";
?>