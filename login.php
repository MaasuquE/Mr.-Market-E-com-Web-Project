
 <?php  
    ob_start();
    include "toper.php"; 
    include "config.php";
    include "fb_login.php";
    $msg ="";
    $msg2="";
    $msg_1="";
    $msg_2="";
    $msg_3="";
    $msg_4="";

    
 ?> 
        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/bg2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">Login</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- End Bradcaump area -->
        <!-- Start Contact Area -->
        <section class="htc__contact__area ptb--100 bg__white" id="login_container">
            <div class="container" >
                <div class="del_boy_log">
                        <button>Login As Deliverboy</button>
                </div>
                <div class="row">
					<div class="col-md-6" >
						<div class="contact-form-wrap mt--60" id="login_site">
							<div class="col-xs-12">
								<div class="contact-title">
									<h2 class="title__line--6">Login</h2>
								</div>
							</div>
							<div class="col-xs-12">
                             <?php 
                                if(isset($_POST['login'])){
                                    $email = strip_tags(mysqli_real_escape_string($conn,$_POST['email']));
                                    $pass = strip_tags(mysqli_real_escape_string($conn,($_POST['password'])));
                                    
                                    $sql_qry = "SELECT * FROM user WHERE email='{$email}' AND password = '{$pass}';";
                                    $res_qry = mysqli_query($conn,$sql_qry);
                                    if(mysqli_num_rows($res_qry) > 0){
                                        while($row=mysqli_fetch_assoc($res_qry)){
                                            session_start();
                                            $_SESSION['USER_LOGIN'] = 'yes';
                                            $_SESSION['user_id'] = $row['id'];
                                            $_SESSION['email'] = $row['email'];
                                            $_SESSION['username'] = $row['name'];
                                            if(isset($_SESSION['checkout'])){ 
                                                header("Location: {$hostname}/cart.php");
                                            }elseif(isset($_SESSION['wishlist'])){
                                                header("Location: {$hostname}/wishlist.php");
                                            }
                                            else {
                                                $_SESSION['alert']="Login Successful!";
                                                $_SESSION['alert_code']="success";
                                                header("Location: {$hostname}/index.php");
                                                ob_end_flush();
                                            }
                                            
                                        }
                                        
                                        
                                    }
                                    else{
                                        $_SESSION['alert']="incorrect Info!";
                                        $_SESSION['alert_code']="error";
                                        $msg2 = "email or password incorrect.";
                                    }
                                }
                              
                             ?> 
								<form id="contact-form" action="#" method="post">
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="email" name="email" placeholder="Your Email*" style="width:100%">
										</div>
									</div>
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="password" name="password" id="password" placeholder="Your Password*" style="width:100%">
                                            <span class="eye_btn">
                                                <i id="eye_show" class="far fa-eye"></i>
                                                <i id="eye_hide" class="far fa-eye-slash"></i>
                                            </span>
										</div>
									</div>
									
									<div class="contact-btn">
										<button type="submit" name="login" class="fv-btn">Login</button>
                                    </div>
                                    <span class="forgot_pass">Forgot Password?</span>
                                    <div>
                                    <p class="message">Already registered? <a >Create an account</a></p>
                                    
                                    </div>
								</form>
                                <div class="or_login">OR</div>
                                <div class="social_login_btn">
                                    <a href="<?php echo $login_url; ?>" class="fb btn">
                                    <i class="fab fa-facebook-square"></i> Login with Facebook
                                    </a>
                                    <a href="#" class="twitter btn">
                                    <i class="fab fa-twitter"></i> Login with Twitter
                                    </a>
                                    <a href="#" class="google btn">
                                    <i class="fab fa-google"></i> Login with Google+
                                    </a>
                                </div>
							</div>
						</div> 
                
				    </div>
				

					<div class="col-md-6">
						<div class="contact-form-wrap mt--60" id="register_site">
							
                                <div class="col-xs-12">
                                    <div class="contact-title">
                                        <h2 class="title__line--6">Register</h2>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <form  action="#" method="post">
                                        <div class="single-contact-form">
                                            <div class="contact-box name">
                                                <input type="text" id="name" placeholder="Your Name*" style="width:100%"><br>
                                                <br><span class="field_error" id="name_error"></span>
                                            </div>
                                        </div>
                                        <div class="single-contact-form">
                                            <div class="contact-box name">
                                                <input type="email" id="reg_email"  placeholder="Your Email*" style="width:100%"><br>
                                                <!-- <button type="button" id="email_otp_btn" onclick="email_sent_otp()" class="fv-btn sent_otp">Send OTP</button>
                                                <input type="text"  id="email_otp" placeholder="Enter OTP" style="width:30">

                                                <button type="button" id="email_verify" onclick="email_verify_otp()" class="fv-btn sent_otp">Verify OTP</button> -->
                                                <br><span class="field_error" id="email_error"></span>
                                            </div>
                                        </div>
                                        <div class="single-contact-form">
                                            <div class="contact-box name">
                                                <input type="number" id="phn" placeholder="Your Mobile*" style="width:100%">

                                                <!--<button type="button" id="send_otp" onclick="moblie_sent_otp()" class="fv-btn sent_otp">Send OTP</button>

                                                <input type="text"  id="mobile_otp" placeholder="Enter OTP" style="width:20" class="verify_otp">

                                                <button type="button" id="send_otp" onclick="moblie_verify_otp()" class="fv-btn verify_otp">Verify OTP</button>-->

                                                <br><span class="field_error" id="phn_error"></span>
                                            </div>
                                        </div>
                                        <div class="single-contact-form">
                                            <div class="contact-box name">
                                                <input type="password" id="password_reg" placeholder="Your Password*" style="width:100%">
                                                <br><span class="field_error" id="pass_error"></span>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="contact-btn">
                                            <button type="button"  class="fv-btn" onclick="register_btn()">Register</button>
                                        </div>
                                    </form>
                                    <div class="form-output">
                                        <p class="form-messege"><b style="color:green"><?php echo $msg; ?></b></p>
                                    </div>
                                </div>
                            
						</div> 
				    </div>
					
                </div>
            </div>
        </section>
        <div class="center">
                <div class="pass_container">
                    <label for="show" class="close-btn fas fa-times" title="close"></label>
                    <div class="text">Reset Password</div><br>
                    <form action="#">
                        <div class="data" id="email_data">
                            <label>Email or Phone</label>
                            <input type="email" id="forgot_email" placeholder="Please your email...." required>
                            <span class="field_error" id="forgot_email_error"></span>
                        </div>
                        <div class="data" id="otp_data">
                            <label>OTP</label>
                            <input type="number" id="forgot_otp" placeholder="Please enter the OTP..." required>
                            <span class="field_error" id="forgot_otp_error"></span>
                        </div>
                        <div id="newpass_data">
                            <div class="data">
                                <label>New Password</label>
                                <input type="password" id="newpss1" placeholder="Please enter a new password..." required>
                                <span class="field_error" id="newpass1_error"></span><br><br>
                            </div>
                            <div class="data">
                                <label>Confirm Password</label>
                                <input type="password" id="newpss2" placeholder="Please enter confirm password..." required>
                                <span class="field_error" id="newpass2_error"></span><br><br>
                            </div>
                        </div><br>
                        <div class="radio_btn">
                            <br><input type="checkbox" name="radio" id="login_radio1" value="stay" required> Stay Logged in
                        </div>
                        
                        <div class="btn">
                            <div class="inner"></div>
                            <button type="button" id="otp_to_email">Send OTP</button>
                        </div>
                        <div class="signup-link">Not a member? 
                            <a href="login.php">Signup now</a>
                        </div>
                    </form>

                </div>
            </div>
        
        
            <div id="del_boy_log">
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close">&times;</span>
                    </div>
                    <div class="modal-body">
                        <h2>Login As Delivery Boy</h2>
                        <div id="del_boy_form">
                            <form action="" method="post">
                                <div class="log_error">
                                </div>
                                <input type="email" id="email" placeholder="Email">
                                <input type="password" id="pass" placeholder="Password">
                                <button type="button" onclick="del_boy_log()">Submit</button><br>
                                <div class="del_reg">Haven't Account?<span class="del_reg_btn">Register Now</span></div>
                                
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
<?php include "footer.php";  ?> 
<?php 
         if(isset($_SESSION['alert']) && $_SESSION['alert_code'] =='error'){ ?>
            <script>
               swal({
                  title: "<?php echo $_SESSION['alert']; ?>",
                  //text: "You clicked the button!",
                  icon: "<?php echo $_SESSION['alert_code']; ?>",
                  button: "ok",
               });
            </script>
         <?php 
            unset($_SESSION['alert']);
            unset($_SESSION['alert_code']);
         } 
?>
