<?php  
    include "config.php";
    include "function.inc.php";
    session_start();
    date_default_timezone_set("Asia/Dhaka");
    ///----Count Visitor---///
    $ip_adress=$_SERVER['REMOTE_ADDR'];
    $date=date("Y-m-d h:i:sa");
    $insrt_ip="INSERT INTO visitor(ip_address,visiting_date) VALUES('{$ip_adress}','{$date}')";
    $res_vq = mysqli_query($conn,"SELECT * FROM visitor WHERE ip_address='{$ip_adress}'");
    if(mysqli_num_rows($res_vq)==0){
        $insrt_ip="INSERT INTO visitor(ip_address,visiting_date) VALUES('{$ip_adress}','{$date}')";
        mysqli_query($conn,$insrt_ip);
    }
    
    $sql_cat = "SELECT * FROM category 
         WHERE category.status = '1'";
    $res_cat =mysqli_query($conn,$sql_cat);
    $cat_arr = array();
    while($rowd_cat=mysqli_fetch_assoc($res_cat)){
        $cat_arr =$res_cat;
    }
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Mr. Market</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/core.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <link rel="stylesheet" href="css/shortcode/header.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/forgot_pass.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->  

    <!-- Body main wrapper start -->
    <div class="wrapper">
        <!-- Start Header Style -->
        <header id="htc__header" class="htc__header__area header--one">
            <!-- Start Mainmenu Area -->
            <div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header">
                <div class="container">
                    <div class="row">
                        <div class="menumenu__container clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5"> 
                                <div class="logo">
                                     <a href="index.php"><img src="images/logo/4.png" alt="logo images"></a>
                                </div>
                            </div>
                            <div class="col-md-7 col-lg-6 col-sm-5 col-xs-3">
                                <nav class="main__menu__nav hidden-xs hidden-sm">
                                    <ul class="main__menu">
                                        <li class="drop"><a href="index.php">Home</a></li>
                                        <?php 
                                            $res_mw = mysqli_query($conn,"SELECT * FROM category WHERE category_name='men' and status='1'");
                                            if(mysqli_num_rows($res_mw)>0){
                                        ?>
                                        <li class="drop"><a href="#">Men</a>
                                            <?php  
                                            $sql_sb="SELECT * FROM sub_category JOIN category ON sub_category.category_id=category.category_id
                                            WHERE category.category_name='men';";
                                            $res_sb=mysqli_query($conn,$sql_sb);
                                            if(mysqli_num_rows($res_sb) > 0){
                                                            
                                            ?>
                                            <ul class="dropdown">
                                                <?php while($row_sb=mysqli_fetch_assoc($res_sb)){ ?>
                                                <li><a href="category.php?cid=<?php echo $row_sb['category_id']; ?>&sub_cid=<?php echo $row_sb['sub_id']; ?>"><?php echo $row_sb['sub_categories'];  ?></a></li>
                                                <?php } ?>
                                            </ul>
                                            <?php } ?>
                                        </li>
                                        <?php } 
                                            $res_mw = mysqli_query($conn,"SELECT * FROM category WHERE category_name='women' and status='1'");
                                            if(mysqli_num_rows($res_mw)>0){
                                        ?>
                                        <li class="drop"><a href="#">Women</a>
                                            <?php  
                                            $sql_sb="SELECT * FROM sub_category JOIN category ON sub_category.category_id=category.category_id
                                            WHERE category.category_name='women';";
                                            $res_sb=mysqli_query($conn,$sql_sb);
                                            if(mysqli_num_rows($res_sb) > 0){
                                                            
                                            ?>
                                            <ul class="dropdown">
                                                <?php while($row_sb=mysqli_fetch_assoc($res_sb)){ ?>
                                                <li><a href="category.php?cid=<?php echo $row_sb['category_id']; ?>&sub_cid=<?php echo $row_sb['sub_id']; ?>"><?php echo $row_sb['sub_categories'];  ?></a></li>
                                                <?php } ?>
                                            </ul>
                                            <?php } ?>
                                        </li>
                                        <?php } ?>
                                        <!-- <li class="drop"><a href="#">Category</a>
                                            <ul class="dropdown top">
                                                <?php foreach($cat_arr as $list){ 
                                                    if($list['category_id']!=32 && $list['category_id']!=33){?>
                                                    <li class="drop menu_sb" value="<?php echo $list['category_id']; ?>" onclick="cat_menu('<?php echo $list['category_id']; ?>')"><a ><?php echo $list['category_name'];  ?></a>
                                                    <ul class="dropdown sub_menu" id="sub_menu">
                                                        
                                                    </ul>
                                                </li>
                                                <?php
                                                } 
                                             } ?>
                                            </ul>
                                        </li> -->
                                        <li class="drop"><a href="#">More Category</a>
                                        <ul class="dropdown mega_dropdown">
                                                <!-- Start Single Mega MEnu -->
                                                <?php foreach($cat_arr as $list){ 
                                                    if($list['category_id']!=32 && $list['category_id']!=33){ ?>
                                                <li><a class="mega__title"><?php echo $list['category_name']; ?></a>
                                                        <?php  
                                                            $cat = $list['category_id'];
                                                            $sql_sb = "SELECT * FROM sub_category WHERE category_id={$cat}";
                                                            $res_sb = mysqli_query($conn,$sql_sb);
                                                            if(mysqli_num_rows($res_sb) > 0){
                                                        ?>
                                                    <ul class="mega__item" >
                                                        <?php while($row_sb=mysqli_fetch_assoc($res_sb)){?>
                                                        <li><a href="category.php?cid=<?php echo $row_sb['category_id'];?>&sub_cid=<?php echo $row_sb['sub_id']; ?>"><?php echo $row_sb['sub_categories']; ?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                    <?php } ?>
                                                </li>
                                                
                                                <?php
                                                } 
                                             } ?>
                                                <!-- End Single Mega MEnu -->
                                            </ul>
                                        </li>
                                        <li><a href="contact.php">contact</a></li>
                                    </ul>
                                   
                                </nav>

                                <div class="mobile-menu clearfix visible-xs visible-sm">
                                    <nav id="mobile_dropdown">
                                        <ul>
                                            <li><a href="index.php">Home</a></li>
                                            <?php foreach($cat_arr as $list){ ?>
                                            <li><a href="category.php?cid=<?php echo $list['category_id']; ?>"><?php echo $list['category_name']; ?></a></li>
                                            <?php } ?>
                                            <li><a href="#best_sell">Best Sell</a></li>
                                            <li><a href="contact.php">contact</a></li>
                                        </ul>
                                    </nav>
                                </div>  
                            </div>
                            <div class="col-md-3 col-lg-4 col-sm-4 col-xs-4">
                                <div class="header__right">
                                <?php if(!isset($_SESSION['del_boy'])){ ?>
                                    <div class="del_boy_reg">
                                            <button>Register As Deliverboy</button>
                                    </div>
                                <?php  } ?>
                                    <div class="header__search search search__open">
                                        <a href="#"><i class="icon-magnifier icons"></i></a>
                                    </div>
                                    <div class="header__account">
                                        <?php 
                                            if(isset($_SESSION['USER_LOGIN'])){
                                                    $user=$_SESSION['user_id'];
                                                    $res_us=mysqli_query($conn,"SELECT * FROM user WHERE id={$user}");
                                                    if(mysqli_num_rows($res_us)>0){
                                                        $row_us=mysqli_fetch_assoc($res_us);
                                                    }
                                                ?>
                                                <ul class="main__menu profile_name">
                                                    <li class="drop"><a href="#"><img src="admin/upload/<?php echo $row_us['img']; ?>" alt="Profile Picture"></a>
                                                    
                                                    <ul class="dropdown">
                                                        <li><a href="profile.php">Profile</a></li>
                                                        <li><a href="my_order.php">My Order</a></li>
                                                        <li><a href="logout.php">Logout</a></li>
                                                    </ul>
                                                    </li>
                                                </ul>
                                                
                                            <?php } elseif(isset($_SESSION['del_boy'])){ 
                                                    $user=$_SESSION['del_boy_id'];
                                                    $res_us=mysqli_query($conn,"SELECT * FROM delivery_boy WHERE del_boy_id={$user}");
                                                    if(mysqli_num_rows($res_us)>0){
                                                        $row_us=mysqli_fetch_assoc($res_us);
                                                    }
                                                ?>
                                                <ul class="main__menu profile_name">
                                                    <li class="drop"><a href="#"><img src="admin/upload/<?php echo $row_us['img']; ?>" alt="Profile Picture"></a>
                                                    
                                                    <ul class="dropdown">
                                                        <li><a href="profile.php">Profile</a></li>
                                                        <li><a href="delivery_order.php?type=all">My Order</a></li>
                                                        <li><a href="logout.php">Logout</a></li>
                                                    </ul>
                                                    </li>
                                                </ul>
                                            <?php }else {
                                                echo '<a href="login.php">Login/Register</a>';
                                            }
                                        
                                             ?>
                                    </div>
                                    <?php 
                                        if(isset($_SESSION['USER_LOGIN'])){ 
                                            $user_id = $_SESSION['user_id'];
                                            $sql_sp= "SELECT * FROM cart WHERE user_id = {$user_id} ";
                                            $res_sp = mysqli_query($conn,$sql_sp);
                                            $count = mysqli_num_rows($res_sp);

                                            $sql_w= "SELECT * FROM wishlist WHERE user_id = {$user_id}";
                                            $res_w = mysqli_query($conn,$sql_w);
                                            $count_w = mysqli_num_rows($res_w);
                                        ?>
                                        <div class="htc__shopping__cart">
                                            <a  href="wishlist.php"><i class="icon-heart icons"></i></a>
                                            <a href="#"><span class="htc__qua2"><?php echo $count_w; ?></span></a>
                                            
                                            <a class="cart__menu" href="#"><i class="icon-handbag icons"></i></a>
                                            <a href="#"><span class="htc__qua"><?php echo $count; ?></span></a>
                                        </div>
                                        <?php } if(isset($_SESSION['del_boy'])){ 
                                                $dboy_id=$_SESSION['del_boy_id']; 
                                                $res_dboy = mysqli_query($conn,"SELECT * FROM checkout 
                                                WHERE del_boy_id={$dboy_id} AND payment='cash'");
                                                $aln=mysqli_num_rows($res_dboy);
                                                if($aln>0){
                                            ?>
                                            
                                            <div class="htc__shopping__cart alarm_sec"> 
                                            <a href="delivery_order.php?type=pending"><i class="far fa-bell"></i><span class="htc__qua2 alarm"><?php echo $aln; ?></span></a>
                                            </div>
                                        <?php  } } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-menu-area"></div>
                </div>
            </div>
            <!-- End Mainmenu Area -->
        </header>
        <div id="del_boy_reg">
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close">&times;</span>
                    </div>
                    <div class="modal-body">
                        <h2>Register As Delivery Boy</h2>
                        <div id="del_boy_form">
                            <form action="" method="post">
                                <input type="text" id="del_name" placeholder="Full Name">
                                <input type="email" id="email" placeholder="Email">
                                <input type="number" id="mobile" placeholder="Mobile Number">
                                <input type="number" id="age" placeholder="Age">
                                <input type="text" id="city" placeholder="City">
                                <input type="text" id="address" placeholder="Address">
                                <input type="password" id="del_pass" placeholder="Password">
                                <div class="del_gender">
                                    <span>Gender:</span>
                                    <input type="radio" name="gender" id="male" value="male" checked="checked"> <label for="male"> Male</label>
                                    <input type="radio" name="gender" id="fenale" value="female"><label for="fenale"> Female</label>
                                    <input type="radio" name="gender" id="other" value="others"><label for="other"> Others</label>
                                </div>
                                <button type="button" onclick="del_boy_reg()">Submit</button>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Search Popap -->
        <div class="search__area">
                <div class="container" >
                    <div class="row" >
                        <div class="col-md-12" >
                            <div class="search__inner">
                                <form action="category.php" method="get">
                                    <input id="search" placeholder="Search here... " type="text" name="str">
                                    <button  type="submit"></button>
                                </form>
                                <div class="search__close__btn">
                                    <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- End Search Popap -->
        <!-- End Header Area -->