<?php 
    ob_start();
    include "config.php";
    include "toper.php";
    if(!isset($_SESSION['USER_LOGIN'])){
        $_SESSION['checkout']='yes';
        header("Location:{$hostname}/login.php");
        ob_end_flush();
      }

    if(isset($_GET['type'])){
        if($_GET['type'] == 'remove'){
            $rmv_id=$_GET['pid'];
            $dlt_sql="DELETE FROM cart WHERE product_id={$rmv_id}";
            mysqli_query($conn,$dlt_sql);
        }
        
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
            <!-- Start Cart Panel -->
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
                                  <a class="breadcrumb-item" href="index.php">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">shopping cart</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        <div class="cart-main-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form action="#">               
                            <div class="table-content table-responsive">
                            <?php
                            $type='';
                                if(isset($_GET['type']) && ($_GET['type']=='coin')){
                                        $type='coin';
                                        $user_id = $_SESSION['user_id'];
                                        $sql_cp="SELECT * FROM cart JOIN product ON cart.product_id=product.product_id
                                        WHERE cart.user_id={$user_id} AND cart.buy_type='coin'
                                        ORDER BY cart.cart_id DESC";
                                        $res_cp=mysqli_query($conn,$sql_cp);
                                    
                                }
                                else{
                                    $user_id = $_SESSION['user_id'];
                                    $sql_cp="SELECT * FROM cart JOIN product ON cart.product_id=product.product_id
                                    WHERE cart.user_id={$user_id} AND cart.buy_type!='coin'
                                    ORDER BY cart.cart_id DESC";
                                    $res_cp=mysqli_query($conn,$sql_cp); 
                                }
                                
                                
                            ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail">products</th>
                                            <th class="product-name">name of products</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Total</th>
                                            <th class="product-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cart_tbody">
                                    <?php
                                    if(mysqli_num_rows($res_cp) > 0){
                                        $all_coin=0;
                                     while($row_cp=mysqli_fetch_assoc($res_cp)) { ?>
                                        <tr>
                                            <td class="product-thumbnail"><a href="product-details.php?pid=<?php echo $row_cp['product_id']; ?>"><img src="admin/upload/<?php echo $row_cp['img']; ?>" alt="product img" /></a></td>
                                            <td class="product-name"><a href="product-details.php?pid=<?php echo $row_cp['product_id']; ?>"><?php echo $row_cp['product_name']; ?></a>
                                            <!-- <ul class="fr__pro__prize">
                                                        <?php if($type==''){ if($row_cp['discount']>0){ ?>
                                                        <li class="old__prize"><del>&#2547; <?php echo $row_cp['price']; ?></del></li>
                                                        <li>&#2547; <?php $price=$row_cp['price']-($row_cp['price']*(($row_cp['discount'])/100)); echo $price; ?></li>
                                                        <?php }else{ ?>
                                                        <li>&#2547; <?php echo $row_cp['price']; ?></li>
                                                        <?php } }else{?>
                                                        <div class="coin"><li><i class="fas fa-coins"></i><b> <?php if($row_cp['coin']>1000){
                                                            echo number_format(($row_cp['coin']/1000),2)."k";
                                                        }else{
                                                            echo $row_cp['coin'];
                                                        } }?></b></li></div>
                                               </ul>
                                            </td> -->
                                            <td class="product-price"><span class="amount"><?php 
                                            if($type=='coin'){
                                                if($row_cp['coin']>1000){
                                                    echo '<i class="fas fa-coins"></i> '.number_format(($row_cp['coin']/1000),2)."k";
                                                }
                                                else{
                                                    echo '<i class="fas fa-coins"></i> '.$row_cp['coin'];
                                                }
                                                
                                            }else{
                                                echo "&#2547; ".$row_cp['price'];
                                            }
                                             ?></span></td>
                                            <td class="product-quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="dec qtybutton" onclick="qty_btn('-','<?php echo $row_cp['cart_id']; ?>','<?php echo $type;  ?>')">-</div>
                                                        <input class="cart-plus-minus-box" id="qty" type="text" name="qtybutton" disabled="disabled" value="<?php echo $row_cp['cart_qty']; ?>">
                                                    <div class="inc qtybutton" onclick="qty_btn('+','<?php echo $row_cp['cart_id']; ?>','<?php echo $type;  ?>')">+</div>
                                                </div>
                                            </td>
                                            <td class="product-subtotal"><?php
                                            if($type=='coin'){
                                                $qty=$row_cp['cart_qty'];
                                                $coin=$row_cp['coin'];
                                                $total_coin = $qty * $coin;
                                                 if($total_coin>1000){
                                                echo '<i class="fas fa-coins"></i> '.number_format($total_coin/1000,1)."k"; 
                                                $all_coin = $all_coin + $total_coin; 
                                                 }else{
                                                    echo'<i class="fas fa-coins"></i> '.$total_coin;
                                                    $all_coin = $all_coin + $total_coin;
                                                 }
                                            }
                                            else{
                                                $qty=$row_cp['cart_qty'];
                                                $price=$row_cp['price'];
                                                
                                                echo "&#2547;".$price * $qty; 
                                            }
                                             ?>
                                             </td>
                                            <td class="product-remove" onclick="delete_cart('<?php echo $row_cp['cart_id']; ?>')"><a href="#"><i class="icon-trash icons"></i></a></td>
                                        </tr>
                                        <input type="hidden" id="all_coin" value="<?php echo $all_coin; ?>">
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="buttons-cart--inner">
                                        <div class="buttons-cart">
                                            <a href="index.php">Continue Shopping</a>
                                        </div>
                                        <div class="buttons-cart checkout--btn">
                                            <?php  
                                                if($type=='coin'){
                                                  echo '<a onclick="coin_chk()">checkout</a>';  
                                                }
                                                else{
                                                    echo '<a href="checkout.php">checkout</a>';
                                                }
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
        <!-- cart-main-area end -->
        <!-- End Banner Area -->
        <?php
            include "footer.php";
        ?>