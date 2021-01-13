<?php
    include "config.php";
    include "function.inc.php";
    require('top.inc.php');
    $msg="";
    if(isset($_POST['submit'])){
        $coupon = strtoupper(get_string($conn,$_POST['coupon']));
        $discount=$_POST['discount'];
        $sql ="SELECT * FROM coupon WHERE coupon ='{$coupon}';";
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){
            $msg ="This Coupon Code already exist. please try another";
        }
        else{
            $sql_insrt = "INSERT INTO coupon(coupon,discount,status,uses_time) VALUES('{$coupon}',{$discount},1,0);";
            if(mysqli_query($conn,$sql_insrt)){
                header("Location: {$hostname}/admin/discount_coupon.php");
            }
            else{
                $msg ="Insertation Failed";
            }
        }
    }
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Coupon</strong><small> Form</small></div>
                          <div class="card-body card-block">
                           <form method="post">
							   <div class="form-group">
								<label for="category" class=" form-control-label">Coupon Code</label>
								<input type="text" name="coupon" placeholder="Enter your Coupon Code...." class="form-control" required>
                               </div>
                               <div class="form-group">
								<label for="discount" class=" form-control-label">Discount(%)</label>
								<input type="number" name="discount" placeholder="Enter discount(%) for Coupon..." class="form-control" required>
                               </div>
							   
							   <button  type="submit" name="submit" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount">Submit</span>
							   </button>
							  </form>
                              <div class="result_msg"><?php echo $msg; ?></div>
                          </div>
                     </div>
                  </div>
               </div>
            </div>
    </div>
                  
<?php
require('footer.inc.php');
?>