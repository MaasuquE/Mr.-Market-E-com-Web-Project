<?php 
        include "config.php";
        include "toper.php";
    
      
    $sql = "SELECT product.*,product_rating.rate  FROM product
        LEFT JOIN product_rating ON product.product_id=product_rating.product_id
         ORDER BY product.product_id DESC LIMIT 8";
    $res =mysqli_query($conn,$sql);
    
?>

<div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            
            <!-- Start Cart Panel -->
            <?php 
                if(isset($_SESSION['USER_LOGIN'])){
                    $user_id=$_SESSION['user_id'];
                }else{
                    $user_id=0;
                }
                
                $total=0;
                $sql_sp="SELECT * FROM cart JOIN product ON cart.product_id=product.product_id 
                WHERE cart.user_id={$user_id}
                ORDER BY cart.cart_id DESC";
                $res_sp=mysqli_query($conn,$sql_sp); 
                if(mysqli_num_rows($res_sp) > 0){
                    while($row_sp=mysqli_fetch_assoc($res_sp)){
            
                ?>
            <div class="shopping__cart">
                <div class="shopping__cart__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                    <div class="shp__cart__wrap">
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
                                <a href="cart.php" title="Remove this item"><i class="zmdi zmdi-close"></i></a>
                            </div>
                        </div>
                    <?php 
                        $total = $total + $row_sp['price'];
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
            <?php } ?>
            <!-- End Cart Panel -->
        </div>
        <!-- End Offset Wrapper -->
        <!-- Start Slider Area -->
        <div class="slider__container slider--one bg__cat--3">
            <div class="slide__container slider__activation__wrap owl-carousel">
                <!-- Start Single Slide -->
                <?php  
                    $res_sld = mysqli_query($conn,"SELECT * FROM slide_product 
                        JOIN product ON slide_product.product_id=product.product_id");
                        
                    if(mysqli_num_rows($res_sld)>0){
                        while($row_sld=mysqli_fetch_assoc($res_sld)){
                ?>
                <div class="single__slide animation__style01 slider__fixed--height">
                    <div class="container">
                        <div class="row align-items__center">
                            <div class="col-md-7 col-sm-7 col-xs-12 col-lg-6">
                                <div class="slide">
                                    <div class="slider__inner">
                                        <h1 class="disc_off"><?php echo $row_sld['discount']; ?>%<br><span>OFF</span></h1>
                                        <h2>collection <?php echo date("M,Y"); ?></h2>
                                        <h1><?php echo $row_sld['product_name']; ?></h1>
                                        <div class="cr__btn">
                                            <a href="product-details.php?pid=<?php echo $row_sld['product_id']; ?>">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-5 col-xs-12 col-md-5">
                                <div class="slide__thumb">
                                    <img src="admin/upload/<?php echo $row_sld['img']; ?>" alt="slider images">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } }else{?>
                <div class="single__slide animation__style01 slider__fixed--height">
                    <div class="container">
                        <div class="row align-items__center">
                            <div class="col-md-7 col-sm-7 col-xs-12 col-lg-6">
                                <div class="slide">
                                    <div class="slider__inner">
                                        <h2>collection <?php echo date("Y"); ?></h2>
                                        <h1>NICE CHAIR</h1>
                                        <div class="cr__btn">
                                            <a href="cart.php">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-5 col-xs-12 col-md-5">
                                <div class="slide__thumb">
                                    <img src="images/bg/1.png" alt="slider images">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            
        </div>
        <!-- End Slider Area -->
        <!-- Start Brand Area -->
        <div class="section2">
            <div class="container">
            <div class="row">
            <section class="icon-slider slider your-carousel slick-initialized slick-slider">
                <div class="slick-list draggable">
                            <h3 class="brand_title">Brand Section</h3>
                   <marquee  id='scroll_news' scrollamount="25" direction="right">
                        <div onMouseOver="document.getElementById('scroll_news').stop();" onMouseOut="document.getElementById('scroll_news').start();">
                        <div class="slick-track" style="opacity: 1; width: 1140px; transform: translate3d(0px, 0px, 0px);">
                                <?php 
                                    $res_brand= mysqli_query($conn,"SELECT * FROM brand GROUP BY brand_name LIMIT 6");
                                    if(mysqli_num_rows($res_brand)>0){
                                        while($row_brand=mysqli_fetch_assoc($res_brand)){?>
                                            <div class="slick-slide slick-active" data-slick-index="5" aria-hidden="false" style="width: 130px;">
                                                <div class="brand_item">
                                                    <div style="width: 100%; display: inline-block;">
                                                        <a href="category.php?bid=<?php echo $row_brand['brand_name']; ?>" tabindex="0">
                                                            <div class="icon-img" title="View All Categories"><span class="">  <img src="brand/upload/<?php  echo $row_brand['brand_logo']; ?>" draggable="true" data-bukket-ext-bukket-draggable="true"></span></div>
                                                        </a>
                                                        <div class="icon-img-caption" title="View All Categories"><a href="category.php?bid=<?php echo $row_brand['brand_name']; ?>" tabindex="0"><?php echo $row_brand['brand_name']; ?></a></div>
                                                    </div>
                                                </div>
                                            </div>
                                      <?php  }
                                    }
                                ?>
                                <div class="slick-slide slick-active" data-slick-index="5" aria-hidden="false" style="width: 130px;">
                                    <div class="brand_item">
                                        <div style="width: 100%; display: inline-block;">
                                            <a href="category.php" tabindex="0">
                                                <div class="icon-img" title="View All Categories"><span class="">  <img src="https://shopurfood.trymydemo.com/public/front/images/icon6.png" draggable="true" data-bukket-ext-bukket-draggable="true"></span></div>
                                            </a>
                                            <div class="icon-img-caption" title="View All Categories"><a href="category.php" tabindex="0">View All</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </marquee> 
            </section>
            </div>
            </div>
        </div>
        <!-- End Brand Area -->
        <!-- Start Category Area -->
        <section class="htc__category__area ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line">New Arrivals</h2>
                        </div>
                    </div>
                </div>
                <div class="htc__product__container">
                    <div class="row">
                        <div class="product__list clearfix mt--30">
                            <!-- Start Single Category -->
                            
                            <?php 
                                //$res = get_product($conn,'latest','2');
                                
                                while($list=mysqli_fetch_assoc($res)){
                            ?>
                            <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="product-details.php?pid=<?php echo $list['product_id']; ?>">
                                            <img src="admin/upload/<?php echo $list['img']; ?>" alt="product images">
                                        </a>
                                    </div>
                                    <div class="fr_product_offer">
                                        <ul class="offer_list">
                                            <li><i class="fas fa-star"></i><span class="rate_text"><?php echo number_format($list['rate'],1); ?></span><div class="offer_msg"><span class="rating_msg">Rating</span><span class="triangle-down"></span></div></li>
                                            <li><i class="fas fa-certificate"><span class="offer_text"><?php echo $list['discount']; ?>%</span></i><div class="offer_msg"><span class="rating_msg">Discount</span><span class="triangle-down"></span></div></li>
                                            <li class="delivery_time"><i class="fas fa-truck"></i><span class="deliver_text">30<span class="min">min</span></span></i><div class="offer_msg"><span class="rating_msg">Delivery time</span><span class="triangle-down"></span></div></li>
                                        </ul>
                                    </div>
                                    <div class="fr__hover__info">
                                        <ul class="product__action">
                                            <li><a href="wishlist.php?pid=<?php echo $list['product_id']; ?>"><i class="icon-heart icons"></i></a></li>

                                            <li><a href="product-details.php?pid=<?php echo $list['product_id']; ?>"><i class="icon-handbag icons"></i></a></li>

                                            <li><a href="#"><i class="icon-shuffle icons"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="fr__product__inner">
                                        <h4><a href="product-details.php?pid=<?php echo $list['product_id']; ?>"><?php echo $list['product_name']; ?></a></h4>
                                        <ul class="fr__pro__prize">
                                            <?php if($list['discount']>0){ ?>
                                            <li class="old__prize"><del>&#2547; <?php echo $list['price']; ?></del></li>
                                            <li>&#2547; <?php $price=$list['price']-($list['price']*(($list['discount'])/100)); echo $price; ?></li>
                                            <?php }else{ ?>
                                            <li>&#2547; <?php echo $list['price']; ?></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <!-- End Single Category -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Category Area -->
        <!-- Start Product Area -->
        <section id="best_sell" class="ftr__product__area ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line">Best Sells</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="product__wrap clearfix">
                    <?php 
                        $sql_bs="SELECT * FROM buy  
                            LEFT JOIN product ON buy.product_id=product.product_id
                            LEFT JOIN product_rating ON buy.product_id=product_rating.product_id
                            GROUP BY buy.product_id 
                            ORDER BY COUNT(buy.product_id) DESC";
                        $res_bs = mysqli_query($conn,$sql_bs);
                        if(mysqli_num_rows($res_bs) > 0){
                            while($row_bs=mysqli_fetch_assoc($res_bs)){
                    ?>
                        <!-- Start Single Category -->
                        <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                            <div class="category">
                                <div class="ht__cat__thumb">
                                    <a href="product-details.php?pid=<?php echo $row_bs['product_id']; ?>">
                                        <img src="admin/upload/<?php echo $row_bs['img']; ?>" alt="product images">
                                    </a>
                                </div>
                                <div class="fr__hover__info">
                                    <ul class="product__action">
                                        <li><a href="wishlist.php?pid=<?php echo $row_bs['product_id'];  ?>"><i class="icon-heart icons"></i></a></li>

                                        <li><a href="product-details.php?pid=<?php echo $row_bs['product_id']; ?>"><i class="icon-handbag icons"></i></a></li>

                                        <li><a href="#"><i class="icon-shuffle icons"></i></a></li>
                                    </ul>
                                </div>
                                <div class="fr_product_offer">
                                        <ul class="offer_list">
                                            <li><i class="fas fa-star"></i><span class="rate_text"><?php echo number_format($row_bs['rate'],1); ?></span><div class="offer_msg"><span class="rating_msg">Rating</span><span class="triangle-down"></span></div></li>
                                            <li><i class="fas fa-certificate"><span class="offer_text"><?php echo $row_bs['discount']; ?>%</span></i><div class="offer_msg"><span class="rating_msg">Discount</span><span class="triangle-down"></span></div></li>
                                            <li class="delivery_time"><i class="fas fa-truck"></i><span class="deliver_text">30<span class="min">min</span></span></i><div class="offer_msg"><span class="rating_msg">Delivery time</span><span class="triangle-down"></span></div></li>
                                        </ul>
                                    </div>
                                <div class="fr__product__inner">
                                    <h4><a href="product-details.php?pid=<?php echo $row_bs['product_id']; ?>"><?php echo $row_bs['product_name']; ?></a></h4>
                                    <ul class="fr__pro__prize">
                                            <?php if($row_bs['discount']>0){ ?>
                                            <li class="old__prize"><del>&#2547; <?php echo $row_bs['price']; ?></del></li>
                                            <li>&#2547; <?php $price=$row_bs['price']-($row_bs['price']*(($row_bs['discount'])/100)); echo $price; ?></li>
                                            <?php }else{ ?>
                                            <li>&#2547; <?php echo $row_bs['price']; ?></li>
                                            <?php } ?>
                                        </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Category -->
                        <?php
                            }
                        }
                        ?>
                </div>
            </div>
        </section>
        <!-- End Product Area -->
    <?php include "footer.php"; ?>
    <?php 
         if(isset($_SESSION['alert']) && $_SESSION['alert_code'] =='success'){ ?>
            <script>
               swal({
                  title: "<?php echo $_SESSION['alert']; ?>",
                  //text: "You clicked the button!",
                  icon: "<?php echo $_SESSION['alert_code']; ?>",
                  button: "OK",
               });
            </script>
         <?php 
            unset($_SESSION['alert']);
            unset($_SESSION['alert_code']);
         } 
      ?>