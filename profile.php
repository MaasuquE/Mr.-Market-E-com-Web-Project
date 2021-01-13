<?php  
ob_start();
include "config.php";
include "toper.php";
if(!isset($_SESSION['USER_LOGIN']) && !isset($_SESSION['del_boy']) ){
    $_SESSION['checkout']='yes';
    header("Location:{$hostname}/login.php");
    ob_end_flush();
  }
  if(isset($_SESSION['USER_LOGIN'])){
    $user ='normal';
    $user_id=$_SESSION['user_id'];
    $sql="SELECT * FROM user WHERE id={$user_id}";
    $res=mysqli_query($conn,$sql);
    if(mysqli_num_rows($res) >0){
        $row=mysqli_fetch_assoc($res);
    }
  }
  if(isset($_SESSION['del_boy'])){
    $user='del_boy';
    $del_boy_id=$_SESSION['del_boy_id'];
    $sql="SELECT * FROM delivery_boy WHERE del_boy_id={$del_boy_id}";
    $res=mysqli_query($conn,$sql);
    if(mysqli_num_rows($res) >0){
        $row=mysqli_fetch_assoc($res);
    }
  }
    
?>
<link rel="stylesheet" href="css/profile.css">
<div class="container emp-profile">
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src="admin/upload/<?php echo $row['img']; ?>" alt=""/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                        <?php if($user=='del_boy'){
                                           echo $row['boy_name']; 
                                        }else{
                                            echo $row['name'];
                                        } ?>
                                    </h5>
                                    <h6>
                                        <?php if($user=='del_boy'){
                                            echo "Delivery Boy";
                                        } ?>
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
                        <a href="update-profile.php">Edit Profile</a>
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
                                            <div class="col-md-6">
                                                <label>User Id</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php if($user=='del_boy'){
                                                    echo $row['del_boy_id'];
                                                }else{
                                                    echo strtolower($row['name']."".$row['id']);
                                                } ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php if($user=='del_boy'){
                                           echo $row['boy_name']; 
                                        }else{
                                            echo $row['name'];
                                        } ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $row['email']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Phone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $row['mobile']; ?></p>
                                            </div>
                                        </div>
                                        <?php if($user=='del_boy'){ ?>
                                           
                                        <?php  } ?>
                            </div>
                            <?php if($user=='del_boy') { ?>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                    <div class="col-md-6">
                                        <label>Age</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?php echo $row['age']; ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>City</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?php echo $row['city']; ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Address</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?php echo $row['address']; ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Gender</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?php echo $row['gender']; ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Join Date</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p><?php echo $row['boy_added_on']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </form>           
        </div>
<?php   
    include "footer.php";
?>
