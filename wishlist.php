<?php
     ob_start();
     include "config.php";
     include "toper.php";
     if(!isset($_SESSION['USER_LOGIN'])){
         header("Location: {$hostname}/login.php");
         ob_end_flush();
     }


     if(isset($_GET['pid'])){
        $pdt_id=$_GET['pid'];

        $user_id=$_SESSION['user_id'];
        $added_on=date("d M, Y h:i:s");
        $sql_w="SELECT * FROM wishlist WHERE product_id={$pdt_id};";
        $res_w=mysqli_query($conn,$sql_w);
        if(mysqli_num_rows($res_w) > 0){
        }
        else{
            
            $sql_ins="INSERT INTO wishlist(product_id,user_id,added_on)
            VALUES({$pdt_id},{$user_id},'{$added_on}')";
            mysqli_query($conn,$sql_ins);
        }
        
     }
     



    if(isset($_GET['type'])){
        if($_GET['type'] == 'remove'){
            $rmv_id=$_GET['pid'];
            $_SESSION['delete_alert']='yes';
            $dlt_sql="DELETE FROM wishlist WHERE product_id={$rmv_id}";
            if(mysqli_query($conn,$dlt_sql)){
                $_SESSION['deleted']="done";
            }
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
                                  <a class="breadcrumb-item" href="index.html">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">wish-list</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
            <!-- wishlist-area start -->
        <div class="wishlist-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="wishlist-content">
                            <form action="#">
                                <div class="wishlist-table table-responsive">
                                <?php
                                $sql_wl="SELECT * FROM wishlist JOIN product ON wishlist.product_id=product.product_id 
                                WHERE wishlist.user_id = {$user_id}
                                ORDER BY wishlist.wishlist_id DESC";
                                $res_wl=mysqli_query($conn,$sql_wl); 
                                if(mysqli_num_rows($res_wl) > 0){
                                ?>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product-remove"><span class="nobr">Remove</span></th>
                                                <th class="product-thumbnail">Image</th>
                                                <th class="product-name"><span class="nobr">Product Name</span></th>
                                                <th class="product-price"><span class="nobr"> Unit Price </span></th>
                                                <th class="product-stock-stauts"><span class="nobr"> Stock Status </span></th>
                                                <th class="product-add-to-cart"><span class="nobr">Add To Cart</span></th>
                                            </tr>
                                        </thead>
                                        <?php while($row_wl=mysqli_fetch_assoc($res_wl)){ ?>
                                        <tbody>
                                            <tr>
                                                <td class="product-remove"><a href="wishlist.php?type=remove&pid=<?php echo $row_wl['product_id']; ?>">×</a></td>
                                                <td class="product-thumbnail"><a href="#"><img src="admin/upload/<?php echo $row_wl['img'] ;?>" alt="" /></a></td>
                                                <td class="product-name"><a href="#"><?php echo $row_wl['product_name'] ;?></a></td>
                                                <td class="product-price"><span class="amount"><?php echo $row_wl['price'] ;?></span></td>
                                                <input class="hidden" type="number" id="qty" value="2" />
                                                <td class="product-stock-status"><span class="wishlist-in-stock"><?php
                                                    if($row_wl['qty']>1){
                                                                echo "<b>In Stock</b>";
                                                            }else{
                                                                echo "<b style='color:red'>Out Stock<b>";
                                                    }
                                                ?></span></td>
                                                <td><?php if($row_wl['qty']>1){?>
                                                <button type="button" onclick="send_to_cart('<?php echo $row_wl['product_id']; ?>','cart')" ><a class="fr__btn" href="cart.php">Add to Cart</a></button>
                                                <?php }?></td>
                                            </tr>
                                           
                                        </tbody>
                                <?php } }?>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="wishlist-share">
                                                        <h4 class="wishlist-share-title">Share on:</h4>
                                                        <div class="social-icon">
                                                            <ul>
                                                                <li><a href="#"><i class="zmdi zmdi-rss"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-vimeo"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-tumblr"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-pinterest"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-linkedin"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- wishlist-area end -->
        <?php
            include "footer.php";

            if($_SESSION['delete_alert']){ ?>
                <script>
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this imaginary file!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        })
                        .then((willDelete) => {
                        if (willDelete) {
                            swal("Poof! Your imaginary file has been deleted!", {
                            icon: "success",
                            });
                        } else {
                            swal("Your imaginary file is safe!");
                        }
                    });
                </script>
        <?php } ?>