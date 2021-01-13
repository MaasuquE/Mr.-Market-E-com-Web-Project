<?php

ob_start();
include "config.php";
include "toper.php";
$type='checkout';
if(isset($_GET['type'])){
    $type = $_GET['type'];
}
if(!isset($_SESSION['USER_LOGIN'])){
    $_SESSION['checkout']='yes';
    header("Location:{$hostname}/login.php");
    ob_end_flush();
  }
  $res_crt=mysqli_query($conn,"SELECT * FROM cart");
  if(!(mysqli_num_rows($res_crt)>0)){
     header("Location:{$hostname}/cart.php");
  }
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
        <!-- End Offset Wrapper -->
        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/bg2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.html">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">checkout</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        <div class="checkout-wrap ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="checkout__inner">
                            <div class="accordion-list">
                                <div class="accordion">
                                    <div class="accordion__title">
                                        Address Information
                                    </div>
                                    <div class="accordion__body">
                                        <div class="bilinfo">
                                            <form action="#" method="post">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="single-input">
                                                            <input id="name" type="text" placeholder="First name">
                                                            <br><span class="field_error" id="name_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="single-input">
                                                            <input id="street" type="text" placeholder="Street Address">
                                                            <br><span class="field_error" id="street_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="single-input">
                                                            <input id="city" type="text" placeholder="City/State">
                                                            <br><span class="field_error" id="city_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="single-input">
                                                            <input id="post_code" type="text" placeholder="Post code/ zip">
                                                            <br><span class="field_error" id="code_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="single-input">
                                                            <input id="email" type="email" placeholder="Email address">
                                                            <br><span class="field_error"  id="email_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="single-input">
                                                            <input id="phn" type="text" placeholder="Phone number" >
                                                            <br><span class="field_error" id="phn_error"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="accordion__title">
                                        payment information &nbsp;<span class="field_error" id="payment_error">
                                    </div>
                                    <div class="accordion__body">
                                        <div class="paymentinfo">
                                            <div class="single-method">
                                                <input type="radio" name="payment" id="p1"  value="cash" checked="checked" /> <label for="p1"> Cash On Delivery</label>
                                                <br><input type="radio" name="payment" value="online" id="p2" /> <label for="p2"> Credit Card</label>
                                                <br><span class="field_error" id="payment_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php
                            $sub_total =0;
                            $sql = "SELECT * FROM cart JOIN product ON cart.product_id = product.product_id
                                ORDER BY cart.cart_id DESC";
                            $res = mysqli_query($conn,$sql);
                            if(mysqli_num_rows($res) > 0){

                        ?>
                            <div class="order-details">
                                <h5 class="order-details__title">Your Order</h5>
                                <div class="order-details__item">
                                <?php while($row=mysqli_fetch_assoc($res)) { 
                                    if($type=='coin'){
                                    ?>
                                    <div class="single-item">
                                        <div class="single-item__thumb">
                                            <img src="admin/upload/<?php echo $row['img']; ?>" alt="ordered item">
                                        </div>
                                        <div class="single-item__content">
                                            <a href="#"><?php echo $row['product_name']; ?></a>
                                            <span class="price"><i class="fas fa-coins"></i> <?php
                                            $total= $row['coin'] * $row['cart_qty'];
                                            echo $row['coin']."X".$row['cart_qty']."=".'<i class="fas fa-coins"></i> '.$total;
                                            ?></span>
                                        </div>
                                        <div class="single-item__remove">
                                            <a href="#"><i class="zmdi zmdi-delete"></i></a>
                                        </div>
                                    </div>
                                    <?php  }else{ ?>
                                        <div class="single-item">
                                            <div class="single-item__thumb">
                                                <img src="admin/upload/<?php echo $row['img']; ?>" alt="ordered item">
                                            </div>
                                            <div class="single-item__content">
                                                <a href="#"><?php echo $row['product_name']; ?></a>
                                                <span class="price">&#2547; <?php
                                                $total= $row['price'] * $row['cart_qty'];
                                                echo $row['price']."X".$row['cart_qty']."="."&#2547; ".$total;
                                                ?></span>
                                            </div>
                                            <div class="single-item__remove">
                                                <a href="#"><i class="zmdi zmdi-delete"></i></a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php
                                $sub_total += $total;
                            }
                            ?>
                            </div>
                            <div class="calc_dsc">
                                <div class="order-details__count">
                                    <div class="order-details__count__single">
                                        <h5>sub total</h5>
                                        <span class="price"><?php if($type=='coin'){
                                            echo '<i class="fas fa-coins"></i> '.$sub_total;
                                        }else{
                                            echo '&#2547; '.$sub_total;
                                        } ?></span>
                                    </div>
                                    <div class="order-details__count__single">
                                        <h5>Delivery Charge</h5>
                                        <?php if($type=='coin'){ 
                                            echo '<span class="price"><i class="fas fa-coins"></i>300</span>';
                                        }else{
                                            echo '<span class="price">&#2547; 60</span>';
                                        }?>
                                    </div>
                                    <?php if(isset($_SESSION['discount'])){?>
                                    <div class="order-details__count__single" id='discount_manage'>
                                        <h5>Discount</h5>
                                        <span class="price">-<?php echo $_SESSION['discount']; ?>%</span>
                                    </div>
                                    <?php }?>
                                </div>
                                <div class="ordre-details__total">
                                    <h5>Order total</h5>
                                    <span class="price"><?php
                                    $sub_total=$sub_total+60;
                                    if(isset($_SESSION['discount'])){
                                        $disc=$_SESSION['discount'];
                                        $sub_total=$sub_total*((100-$disc)/100);
                                        echo '&#2547; '.$sub_total;
                                    }
                                    else{
                                        if($type=='coin'){
                                            echo '<i class="fas fa-coins"></i> '.($sub_total+(300-60));
                                        }else{
                                            echo '&#2547; '.$sub_total;
                                        }
                                        
                                    }?></span>
                                </div>
                            </div>
                            <?php if(!isset($_SESSION['discount']) && $type!='coin'){?>
                            <div class="discount_site">
                                <input type="text"  id="coupon_code" placeholder="Enter Discount Coupon" />
                                <button type="button" id="discount_coupon" >APPLY</button>
                                <br><span class="field_error" id="coupon_error"></span>
                            </div>
                            <?php } ?>
                            <div class="order_done">
                            <button type="button" onclick="checkout_done('<?php echo $type; ?>')" class="fr__btn">Done!</button>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart-main-area end -->
  <?php include "footer.php"; ?>
