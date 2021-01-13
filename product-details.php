<?php
    include "config.php";
    include "toper.php";
    $type='';
    if(isset($_GET['type'])){
        $type = $_GET['type'];
    }
    if(isset($_GET['pid'])){
        $pdt_id = get_string($conn,$_GET['pid']);

        $sql = "SELECT * FROM product LEFT JOIN category ON product.category=category.category_id
            LEFT JOIN product_rating ON product.product_id=product_rating.product_id
            WHERE product.product_id ={$pdt_id};";
        $res =mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($res);
    } 
    $sms= '<script> function pdtQty(){ var qty_cart = document.getElementById("qty").value;}</script>';
    echo $sms;
    
?>

        <div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            <!-- Start Search Popap -->
            <div class="search__area">
                <div class="container" >
                    <div class="row" >
                        <div class="col-md-12" >
                            <div class="search__inner">
                                <form action="#" method="get">
                                    <input placeholder="Search here... " type="text">
                                    <button type="submit"></button>
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
        </div>
        <!-- End Offset Wrapper --><!-- Start Cart Panel -->
            <div class="shopping__cart">
                <div class="shopping__cart__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                    <div class="shp__cart__wrap">
                         <?php 
                       
                       $total=0;
                       $sql_sp="SELECT * FROM cart JOIN product ON cart.product_id=product.product_id ORDER BY cart.cart_id DESC";
                       $res_sp=mysqli_query($conn,$sql_sp); 
                       if(mysqli_num_rows($res_sp) > 0){
                           while($row_sp=mysqli_fetch_assoc($res_sp)){
                   
                        ?>
                        <div class="shp__single__product">
                            <div class="shp__pro__thumb">
                                <a href="#">
                                    <img src="admin/upload/<?php echo $row_sp['img']; ?>" alt="product images">
                                </a>
                            </div>
                            <div class="shp__pro__details">
                                <h2><a href="product-details.html"><?php echo $row_sp['product_name']; ?></a></h2>
                                <span class="quantity"><?php echo $row_sp['qty']; ?></span>
                                <span class="shp__price"><?php echo $row_sp['price']; ?></span>
                            </div>
                            <div class="remove__btn">
                                <a href="#" title="Remove this item"><i class="zmdi zmdi-close"></i></a>
                            </div>
                        </div>
                    <?php 
                        $total = $total + $row_sp['price'];
                        }
                    }
                    ?>
                    </div>
                    <ul class="shoping__total">
                        <li class="subtotal">Subtotal:</li>
                        <li class="total__price">$<?php echo $total; ?></li>
                    </ul>
                    <ul class="shopping__btn">
                        <li><a href="cart.php">View Cart</a></li>
                        <li class="shp__checkout"><a href="checkout.php">Checkout</a></li>
                    </ul>
                </div>
            </div>
            <!-- End Cart Panel -->
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
                                  <a class="breadcrumb-item" href="category.php?cid=<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active"><?php 
                                    echo $row['product_name'];
                                  ?></span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- Start Product Details Area -->
        <section class="htc__product__details bg__white ptb--100">
            <!-- Start Product Details Top -->
            <div class="htc__product__details__top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                            <div class="htc__product__details__tab__content">
                                <!-- Start Product Big Images -->
                                <div class="product__big__images">
                                    <div class="portfolio-full-image tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="img-tab-1">
                                            <img src="admin/upload/<?php echo $row['img']; ?>" alt="full-image">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Product Big Images -->
                                
                            </div>
                        </div>
                        <form  method="POST" >
                        <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12 smt-40 xmt-40">
                        
                            <div class="ht__product__dtl">
                                <h2><?php echo $row['product_name']; ?></h2>
                                <ul  class="pro__prize">
                                    <?php if($row['discount']>0){ ?>
                                    <li class="old__prize"><del>&#2547; <?php echo $row['price'] ?></del></li>
                                    <li>&#2547; <?php $price=$row['price']-($row['price']*(($row['discount'])/100)); echo $price; ?></li>
                                    <li class="disc_show">-<?php echo $row['discount']; ?>%</li>
                                    <?php }else{ ?>
                                    <li>&#2547; <?php echo $row['price']; ?></li>
                                    <?php } if($type=='coin'){?>
                                        <div class="coin"><i class="fas fa-coins"></i><b> <?php if($row['coin']>1000){
                                                 echo number_format(($row['coin']/1000),2)."k";
                                         }else{echo $row['coin'];} ?></b></div>
                                        <?php } ?>
                                    
                                </ul>
                                <p class="pro__info"><?php echo $row['long_desc']; ?></p>
                                <div class="ht__pro__desc">
                                    <div class="sin__desc">
                                        <p><span>Availability:</span>
                                        <?php 
                                            if($row['qty']>0){
                                                echo "<b>In Stock</b>";
                                            }else {
                                                echo "<b style='color:red'>Stock Out</b>";
                                            }
                                        
                                        ?></p>
                                    </div>
                                
                                    <div class="sin__desc align--left ">
                                        <span>size: </span>
                                        <select class="select__size">
                                            <option>s</option>
                                            <option>l</option>
                                            <option>xs</option>
                                            <option selected>xl</option>
                                            <option>m</option>
                                            <option>s</option>
                                        </select>
                                    </div>
                                    <div class="sin__desc align--left product-quantity">
                                        <span>Quantity: </span>
                                        <div class="cart-plus-minus">
                                            <div class="dec qtybutton" onclick="details_qty_btn('-','<?php echo $row['qty']; ?>')"><i class="fas fa-minus"></i></div>
                                                <input class="cart-plus-minus-box" id="qty" type="text" name="qtybutton" disabled="disabled" value="1">
                                            <div class="inc qtybutton" onclick="details_qty_btn('+','<?php echo $row['qty']; ?>')"><i class="fas fa-plus"></i></div>
                                        </div>
                                    </div>
                                    <div class="sin__desc align--left">
                                        <p><span>Categories:</span></p>
                                        <ul class="pro__cat__list">
                                            <li><a href="category.php?cid=<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></a></li>
                                        </ul>
                                    </div><br>
                                    <?php if($row['qty']>0){ ?>
                                    <div>
                                        <button type="button" onclick="send_to_cart('<?php echo $pdt_id;?>','cart')"  name="cart"><a class="fr__btn" href="cart.php">Add to Cart</a></button>
                                        <?php if($type=='coin'){ ?>
                                        <button type="button" onclick="send_to_cart('<?php echo $pdt_id;?>','coin')"  name="cart"><a class="fr__btn" href="cart.php?type=coin">Buy Using Coin</a></button>
                                        <?php } ?>                                      
                                    </div>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    
                </div>
            </div>
            <!-- End Product Details Top -->
        </section>
        <!-- End Product Details Area -->
        <!-- Start Product Description -->
        
        <section class="htc__produc__decription bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Start List And Grid View -->
                        <ul class="pro__details__tab" role="tablist">
                            <li role="presentation" class="description active"><a href="#description" role="tab" data-toggle="tab">description</a></li>
                            <li role="presentation" class="description "><a href="#description2" role="tab" data-toggle="tab">Review</a></li>
                        </ul>
                        <!-- End List And Grid View -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="ht__pro__details__content">
                            <!-- Start Single Content -->
                            <div role="tabpanel" id="description" class="pro__single__content tab-pane fade in active">
                                <div class="pro__tab__content__inner">
                                    <p>Formfitting clothing is all about a sweet spot. That elusive place where an item is tight but not clingy, sexy but not cloying, cool but not over the top. Alexandra Alvarez’s label, Alix, hits that mark with its range of comfortable, minimal, and neutral-hued bodysuits.</p>
                                    <h4 class="ht__pro__title">Description</h4>
                                    <p><?php echo $row['long_desc']; ?></p>
                                    <h4 class="ht__pro__title">Standard Featured</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in</p>
                                </div>
                            </div>
                            <!-- End Single Content -->
                            <?php 
                                $persons=0;  
                                $rate=0;
                                $res_rate = mysqli_query($conn,"SELECT * FROM product_rating WHERE product_id={$pdt_id}");
                                if(mysqli_num_rows($res_rate)>0){
                                    $row_rate=mysqli_fetch_assoc($res_rate);
                                    $persons=$row_rate['1_star']+$row_rate['2_star']+$row_rate['3_star']+$row_rate['4_star']+$row_rate['5_star'];
                                    $rate=(1*$row_rate['1_star']+2*$row_rate['2_star']+3*$row_rate['3_star']+4*$row_rate['4_star']+5*$row_rate['5_star'])/$persons;
                               
                                
                            ?>
                            <div role="tabpanel" id="description2" class="pro__single__content tab-pane fade">
                                <div class="pro__tab__content__inner">
                                    <div class="user_raing_head">
                                    
                                        <span class="heading">User Rating</span>
                                        <?php for($i=1;$i<=floor($rate);$i++){ ?>
                                        <span class="fa fa-star checked"></span>
                                        <?php  } for($i=floor($rate);$i<5;$i++){ ?>
                                        <span class="fa fa-star"></span><?php  } ?>
                                        <p><?php echo number_format($rate,2)." average based on ".$persons." reviews." ?></p>
                                    </div>
                                        <hr style="border:3px solid #f1f1f1">
                                    <div class="row rating_bar">
                                        <div class="side">
                                            <div>5 star</div>
                                        </div>
                                        <div class="middle">
                                            <div class="bar-container">
                                            <div class="bar-5"></div>
                                            </div>
                                        </div>
                                        <div class="side right">
                                            <div><?php echo $row_rate['5_star']; ?></div>
                                        </div>
                                        <div class="side">
                                            <div>4 star</div>
                                        </div>
                                        <div class="middle">
                                            <div class="bar-container">
                                            <div class="bar-4"></div>
                                            </div>
                                        </div>
                                        <div class="side right">
                                            <div><?php echo $row_rate['4_star']; ?></div>
                                        </div>
                                        <div class="side">
                                            <div>3 star</div>
                                        </div>
                                        <div class="middle">
                                            <div class="bar-container">
                                            <div class="bar-3"></div>
                                            </div>
                                        </div>
                                        <div class="side right">
                                            <div><?php echo $row_rate['3_star']; ?></div>
                                        </div>
                                        <div class="side">
                                            <div>2 star</div>
                                        </div>
                                        <div class="middle">
                                            <div class="bar-container">
                                            <div class="bar-2"></div>
                                            </div>
                                        </div>
                                        <div class="side right">
                                            <div><?php echo $row_rate['2_star']; ?></div>
                                        </div>
                                        <div class="side">
                                            <div>1 star</div>
                                        </div>
                                        <div class="middle">
                                            <div class="bar-container">
                                            <div class="bar-1"></div>
                                            </div>
                                        </div>
                                        <div class="side right">
                                            <div><?php echo $row_rate['1_star']; ?></div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row comment_sec">
                                         <h4 class="comment_heading">Comment</h4>
                                         <div class="comment_area">
                                             <?php 
                                                $img_url = "pp.jpg";
                                                if(isset($_SESSION['user_id'])){
                                                $user_id =$_SESSION['user_id'];
                                                $res =mysqli_query($conn,"SELECT * FROM user WHERE id={$user_id}");
                                                $row=mysqli_fetch_assoc($res);
                                                $img_url=$row['img'];
                                                }
                                                
                                             ?>
                                             <div class="add_comment">
                                                <img src="admin/upload/<?php echo $img_url; ?>" alt="Username">
                                                <input type="text" id="comment" placeholder="Add Your Comment......">
                                                <input type="hidden" id="pid_cmnt" value="<?php echo $pdt_id; ?>">
                                                <i  class="far fa-paper-plane"></i>
                                             </div>
                                             
                                             <div id="show_comment">
                                                <?php  
                                                    $sql_c = "SELECT * FROM product_comment JOIN user ON product_comment.user_id=user.id
                                                        WHERE product_comment.product_id={$pdt_id} ORDER BY product_comment.comment_id DESC";
                                                    $res_c = mysqli_query($conn,$sql_c);
                                                    if(mysqli_num_rows($res_c)>0){
                                                        while($row_c=mysqli_fetch_assoc($res_c)){
                                                ?>
                                                <div class="single_comment">
                                                    <img src="admin/upload/<?php echo $row_c['img']; ?>" alt="Username"><span class="cmnt_user"><?php echo $row_c['name']; ?></span>
                                                    <p><?php echo $row_c['comment']; ?></p>
                                                    <div class="sub_sec">
                                                        <span class="comment_date"><?php echo $row_c['comment_date']; ?></span>
                                                        <span class="comment_action"><i onclick="like_dislike('like','<?php echo $row_c['comment_id']; ?>','<?php echo $pdt_id;?>')" class="fas fa-thumbs-up"></i> <?php echo $row_c['comment_like']; ?><i onclick="like_dislike('dislike','<?php echo $row_c['comment_id']; ?>','<?php echo $pdt_id;?>')" class="fas fa-thumbs-down"></i> <?php echo $row_c['comment_dislike']; ?></span>
                                                        <span id="reply_comment"><i class="fas fa-reply"></i></span>
                                                        <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id']==$row_c['user_id']){ ?>
                                                        <span id="delete_comment" onclick="delete_comment('<?php echo $row_c['comment_id']; ?>','<?php echo $pdt_id; ?>')"><i class="fas fa-trash"></i></span>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <?php } } ?>
                                             </div>
                                            
                                         </div>
                                    </div>
                                </div>
                            
                            </div>
                            <?php } else {?>
                                <div role="tabpanel" id="description2" class="pro__single__content tab-pane fade">
                                    <div class="pro__tab__content__inner">
                                        <div class="user_raing_head">
                                        
                                            <span class="heading">User Rating</span>
                                            <?php if($rate>0){
                                                for($i=1;$i<=round($rate);$i++){
                                                    echo '<span class="fa fa-star checked"></span>';
                                                }
                                                for($i=round($rate);$i<5;$i++){
                                                    echo '<span class="fa fa-star"></span>';
                                                }
                                            }
                                            else{
                                            ?>
                                            
                                            <?php  for($i=1;$i<=5;$i++){ ?>
                                            <span class="fa fa-star"></span><?php  }} ?>
                                            <p>0 average based on 0 reviews0</p>
                                        </div>
                                            <hr style="border:3px solid #f1f1f1">
                                        <div class="row rating_bar">
                                            <div class="side">
                                                <div>5 star</div>
                                            </div>
                                            <div class="middle">
                                                <div class="bar-container">
                                                <div class="bar-5"></div>
                                                </div>
                                            </div>
                                            <div class="side right">
                                                <div>0</div>
                                            </div>
                                            <div class="side">
                                                <div>4 star</div>
                                            </div>
                                            <div class="middle">
                                                <div class="bar-container">
                                                <div class="bar-4"></div>
                                                </div>
                                            </div>
                                            <div class="side right">
                                                <div>0</div>
                                            </div>
                                            <div class="side">
                                                <div>3 star</div>
                                            </div>
                                            <div class="middle">
                                                <div class="bar-container">
                                                <div class="bar-3"></div>
                                                </div>
                                            </div>
                                            <div class="side right">
                                                <div>0</div>
                                            </div>
                                            <div class="side">
                                                <div>2 star</div>
                                            </div>
                                            <div class="middle">
                                                <div class="bar-container">
                                                <div class="bar-2"></div>
                                                </div>
                                            </div>
                                            <div class="side right">
                                                <div>0</div>
                                            </div>
                                            <div class="side">
                                                <div>1 star</div>
                                            </div>
                                            <div class="middle">
                                                <div class="bar-container">
                                                <div class="bar-1"></div>
                                                </div>
                                            </div>
                                            <div class="side right">
                                                <div>0</div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="row comment_sec">
                                            <h4 class="comment_heading">Comment</h4>
                                            <div class="comment_area">
                                                <?php 
                                                    $img_url = "pp.jpg";
                                                    if(isset($_SESSION['user_id'])){
                                                    $user_id =$_SESSION['user_id'];
                                                    $res =mysqli_query($conn,"SELECT * FROM user WHERE id={$user_id}");
                                                    $row=mysqli_fetch_assoc($res);
                                                    $img_url=$row['img'];
                                                    }
                                                    
                                                ?>
                                                <div class="add_comment">
                                                    <img src="admin/upload/<?php echo $img_url; ?>" alt="Username">
                                                    <input type="text" id="comment" placeholder="Add Your Comment......">
                                                    <input type="hidden" id="pid_cmnt" value="<?php echo $pdt_id; ?>">
                                                    <i  class="far fa-paper-plane"></i>
                                                </div>
                                                
                                                <div id="show_comment">
                                                    <?php  
                                                        $sql_c = "SELECT * FROM product_comment JOIN user ON product_comment.user_id=user.id
                                                            WHERE product_comment.product_id={$pdt_id} ORDER BY product_comment.comment_id DESC";
                                                        $res_c = mysqli_query($conn,$sql_c);
                                                        if(mysqli_num_rows($res_c)>0){
                                                            while($row_c=mysqli_fetch_assoc($res_c)){
                                                    ?>
                                                    <div class="single_comment">
                                                        <img src="admin/upload/<?php echo $row_c['img']; ?>" alt="Username"><span class="cmnt_user"><?php echo $row_c['name']; ?></span>
                                                        <p><?php echo $row_c['comment']; ?></p>
                                                        <div class="sub_sec">
                                                            <span class="comment_date"><?php echo $row_c['comment_date']; ?></span>
                                                            <span class="comment_action"><i onclick="like_dislike('like','<?php echo $row_c['comment_id']; ?>','<?php echo $pdt_id;?>')" class="fas fa-thumbs-up"></i> <?php echo $row_c['comment_like']; ?><i onclick="like_dislike('dislike','<?php echo $row_c['comment_id']; ?>','<?php echo $pdt_id;?>')" class="fas fa-thumbs-down"></i> <?php echo $row_c['comment_dislike']; ?></span>
                                                            <span id="reply_comment"><i class="fas fa-reply"></i></span>
                                                            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id']==$row_c['user_id']){ ?>
                                                            <span id="delete_comment" onclick="delete_comment('<?php echo $row_c['comment_id']; ?>','<?php echo $pdt_id; ?>')"><i class="fas fa-trash"></i></span>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <?php } } ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- The Modal -->
            <div id="myModal" class="modal">
            ​
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                <div class="modal_container">
                    <form action="">
                        <div class="row">
                            <h2 style="text-align:center">Login with Social Media or Manually</h2>
                            <div class="vl">
                                <span class="vl-innertext">or</span>
                            </div>

                            <div class="col madal_social">
                                <a href="#" class="fb btn">
                                <i class="fa fa-facebook fa-fw"></i> Login with Facebook
                                </a>
                                <a href="#" class="twitter btn">
                                <i class="fa fa-twitter fa-fw"></i> Login with Twitter
                                </a>
                                <a href="#" class="google btn"><i class="fa fa-google fa-fw">
                                </i> Login with Google+
                                </a>
                            </div>

                            <div class="col">
                                <div class="hide-md-lg">
                                    <p>Or sign in manually:</p>
                                </div>

                                <input type="text" name="username" id="email" placeholder="Username" required>
                                <span class="field_error" id="email_error"></span>
                                <input type="password" name="password" id="pass" placeholder="Password" required>
                                <span class="field_error" id="pass_error"></span>
                                <input type="button" onclick="modal_login()" value="Login">
                                <span  id="login_error"></span>
                            </div>
                        
                        </div>
                    </form>
                </div>

                <div class="bottom-container">
                <div class="row">
                    <div class="col">
                    <a href="login.php" style="color:white" class="btn">Sign up</a>
                    </div>
                    <div class="col">
                    <a href="#" style="color:white" class="btn">Forgot password?</a>
                    </div>
                </div>
                </div>

                </div>
            </div>   ​
        </div>

<?php include "footer.php";  ?>