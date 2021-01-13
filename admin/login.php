<?php  
   include "config.php";
   include "function.inc.php";
   session_start();
   if(isset($_SESSION['ADMIN_LOGIN'])){
      header("Location: {$hostname}/admin/category.php");
   }
   $msg="";
   if(isset($_POST['login'])){
      $username = get_string($conn,$_POST['username']);
      $password =get_string($conn,$_POST['password']);
      $sql = "SELECT * FROM admin_user WHERE username = '{$username}' AND password='{$password}';";
      $res = mysqli_query($conn,$sql);
      if(mysqli_num_rows($res) > 0){
         while($row = mysqli_fetch_assoc($res)){
            $_SESSION['ADMIN_LOGIN']='yes';
            $_SESSION['username'] = $row['username'];
            $_SESSION['alert']="Login Successful!";
            $_SESSION['alert_code']="success";
            header("Location: {$hostname}/admin/index.php");
        }
         
      }
      else{
         $_SESSION['alert']="Incorect Info!";
         $_SESSION['alert_code']="error";
         $msg= "username or password incorrect";
      }
   }
?>
<!doctype html>
<html class="no-js" lang="">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Login Page</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="assets/css/normalize.css">
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="assets/css/themify-icons.css">
      <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
      <link rel="stylesheet" href="assets/css/flag-icon.min.css">
      <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
   </head>
   <body class="bg-dark">
      <div class="sufee-login d-flex align-content-center flex-wrap">
         <div class="container">
            <div class="login-content">
               <div class="login-form mt-150">
                  <form method="post">
                     <h4>Admin Login</h4>
                     <div class="form-group">
                        <label>User Name</label>
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                     </div>
                     <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                     </div>
                     <button type="submit" name ="login" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
					 <div class="result_msg"><?php echo $msg; ?></div>
					</form>
               </div>
            </div>
         </div>
      </div>
      <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
      <script src="assets/js/popper.min.js" type="text/javascript"></script>
      <script src="assets/js/plugins.js" type="text/javascript"></script>
      <script src="assets/js/main.js" type="text/javascript"></script>
      <script src="assets/js/sweet-alert.js" type="text/javascript"></script>
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
   </body>
</html>