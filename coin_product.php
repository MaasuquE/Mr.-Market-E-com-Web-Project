<?php
    include "config.php";
    include "toper.php";

        $sql="SELECT product.*,product_rating.rate  FROM product
        LEFT JOIN category ON product.category=category.category_id
        LEFT JOIN product_rating ON product.product_id=product_rating.product_id
        WHERE product.coin>0 ORDER BY product.brand_id DESC";
        $res=mysqli_query($conn,$sql);


?>

        <div class="body__overlay"></div>
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
                                  <a class="breadcrumb-item" href="#">Coin Product</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- Start Product Grid -->
        <section class="htc__product__grid bg__white ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12  col-sm-12 col-xs-12">
                        <div class="htc__product__rightidebar">
                            <!-- Start Product View -->
                            <div class="row">
                                <div class="shop__grid__view__wrap">
                                    <div role="tabpanel" id="grid-view" class="single-grid-view tab-pane fade in active clearfix">
                                        <!-- Start Single Product -->
                                        <?php
                                        if(mysqli_num_rows($res)>0){
                                        while($row=mysqli_fetch_assoc($res)) { ?>
                                        <div class="col-md-3 col-lg34 col-sm-6 col-xs-12">
                                            <div class="category">
                                                <div class="ht__cat__thumb">
                                                    <a href="product-details.php?pid=<?php echo $row['product_id']; ?>&type=coin">
                                                        <img src="admin/upload/<?php echo $row['img']; ?>" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="fr_product_offer">
                                                    <ul class="offer_list">
                                                        <li><i class="fas fa-star"></i><span class="rate_text"><?php echo number_format($row['rate'],1); ?></span><div class="offer_msg"><span class="rating_msg">Rating</span><span class="triangle-down"></span></div></li>
                                                        <li><i class="fas fa-certificate"><span class="offer_text"><?php echo $row['discount']; ?>%</span></i><div class="offer_msg"><span class="rating_msg">Discount</span><span class="triangle-down"></span></div></li>
                                                        <li class="delivery_time"><i class="fas fa-truck"></i><span class="deliver_text">30<span class="min">min</span></span></i><div class="offer_msg"><span class="rating_msg">Delivery time</span><span class="triangle-down"></span></div></li>
                                                    </ul>
                                                </div>
                                                <div class="fr__hover__info">
                                                    <ul class="product__action">
                                                        <li><a href="wishlist.php?pid=<?php echo $row['product_id']; ?>"><i class="icon-heart icons"></i></a></li>

                                                        <li><a href="product-details.php?pid=<?php echo $row['product_id']; ?>&type=coin"><i class="icon-handbag icons"></i></a></li>

                                                        <li><a href="#"><i class="icon-shuffle icons"></i></a></li>
                                                    </ul>
                                                </div>
                                                <div class="fr__product__inner">
                                                    <h4><a href="product-details.php?pid=<?php echo $row['product_id']; ?>&type=coin"><?php echo $row['product_name']; ?></a></h4>
                                                    <ul class="fr__pro__prize">
                                                        <?php if($row['discount']>0){ ?>
                                                        <li class="old__prize"><del>&#2547; <?php echo $row['price']; ?></del></li>
                                                        <li>&#2547; <?php $price=$row['price']-($row['price']*(($row['discount'])/100)); echo $price; ?></li>
                                                        <?php }else{ ?>
                                                        <li>&#2547; <?php echo $row['price']; ?></li>
                                                        <?php } ?>
                                                        
                                                    </ul>
                                                    <div class="coin"><i class="fas fa-coins"></i><b> <?php if($row['coin']>1000){
                                                            echo number_format(($row['coin']/1000),2)."k";
                                                        }else{
                                                            echo $row['coin'];
                                                        } ?></b></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } 
                                        }
                                        else{
                                            echo '<h2 align="center">Data Not Found.</h2>';
                                        }
                                        ?>
                                        <!-- End Single Product -->
                                       
                                    </div>
                                </div>
                            </div>
                            <!-- End Product View -->
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </section>
        <!-- End Product Grid -->
        <!-- Start Brand Area -->
        
        <!-- End Brand Area -->
        <!-- Start Banner Area -->
        
        <!-- End Banner Area -->
        <!-- End Banner Area -->



<?php include "footer.php"; ?>
