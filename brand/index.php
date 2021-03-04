
<?php include "config.php";
    include "toper.php";
    
  ?>
  <div class="welcome">
    <h1>Wellcome To Brand Pannel</h1>
  </div>

  <div class="row ">
      <div class="col-md-3 dial-box">
          <div class="order_number">
              <h2>
                <?php 
                 $brand_id = $_SESSION['brand_id'];
                  $sql_tp = mysqli_query($conn,"SELECT * FROM product WHERE brand_id = $brand_id");
                  echo mysqli_num_rows($sql_tp);
                ?>
              </h2>
              <i class="fab fa-shopify"></i>
              <h3>Total Product</h3>
          </div>
      </div>
      <div class="col-md-3 dial-box">
        <div class="selling_rate">
              <h2>1%</h2>
              <i class="fab fa-shopify"></i>
              <h3>Selling Rate</h3>
          </div>
      </div>
      <div class="col-md-3 dial-box">
        <div class="order_number">
              <h2>
                <?php 
                  $brand_id = $_SESSION['brand_id'];
                    $sql_tp = mysqli_query($conn,"SELECT * FROM buy
                      LEFT JOIN product ON buy.product_id=product.product_id
                     WHERE product.brand_id = $brand_id");
                    echo mysqli_num_rows($sql_tp);
                  ?>
              </h2>
              <i class="fab fa-shopify"></i>
              <h3>Today's Order</h3>
          </div>
      </div>
      <div class="col-md-3 dial-box">
            <div class="order_number">
              <h2>1</h2>
              <i class="fab fa-shopify"></i>
              <h3>Today's Order</h3>
          </div>
      </div>
  </div>
 


<?php include "footer.php"; ?>