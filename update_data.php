<?php  
    include "config.php";
    session_start();
    date_default_timezone_set("Asia/Dhaka");
    if(isset($_POST['term'])){
        $type=mysqli_real_escape_string($conn,$_POST['term']);    
    }

    function commentPage(){
        include "config.php";
        if(isset($_POST['pid'])){
            $pid=$_POST['pid'];
        }
        $like="like";
        $dislike="dislike";
        $sql_c = "SELECT * FROM product_comment JOIN user ON product_comment.user_id=user.id
        WHERE product_comment.product_id={$pid} ORDER BY product_comment.comment_id DESC";
        $res_c = mysqli_query($conn,$sql_c);
        if(mysqli_num_rows($res_c)>0){
            while($row_c=mysqli_fetch_assoc($res_c)){
                $html='<div class="single_comment">
                <img src="admin/upload/'.$row_c['img'].'" alt="Username"><span class="cmnt_user">'.$row_c['name'].'</span>
                <p>'.$row_c['comment'].'</p>
                <div class="sub_sec">
                    <span class="comment_date">'.$row_c['comment_date'].'</span>
                    <span class="comment_action"><i onclick="like_dislike('.$like.','.$row_c['comment_id'].','.$pid.')" class="fas fa-thumbs-up"></i>'.$row_c['comment_like'].'<i onclick="like_dislike('.$dislike.','.$row_c['comment_id'].','.$pid.')" class="fas fa-thumbs-down"></i>'.$row_c['comment_dislike'].'</span>
                    <span id="reply_comment"><i class="fas fa-reply"></i></span>';
                    if(isset($_SESSION['user_id']) && $_SESSION['user_id']==$row_c['user_id']){
                    $html.='<span id="delete_comment" onclick="delete_comment('.$row_c['comment_id'].','.$pid.')"><i class="fas fa-trash"></i></span>';
                    }
                $html.='</div>
            </div>';
            echo $html;
            }
        }
    }
    if($type=='profile_update'){
        $user_id=$_POST['uid'];
        $name=mysqli_real_escape_string($conn,$_POST['name']);
        $email=mysqli_real_escape_string($conn,$_POST['email']);
        $phn=mysqli_real_escape_string($conn,$_POST['phn']);
        $pass=mysqli_real_escape_string($conn,$_POST['pass']);
        $old_pass=mysqli_real_escape_string($conn,$_POST['old_pass']);
        if($pass==''){
            $pass_sql='';
        }else{
            $pass_sql=",password='{$pass}'";
        }
        $sql_old = "SELECT * FROM user WHERE id={$user_id} AND password='{$old_pass}'";
        $res_old = mysqli_query($conn,$sql_old);
        if(mysqli_num_rows($res_old)>0){
            $sql="UPDATE user SET name='{$name}',email='{$email}',mobile='{$phn}'{$pass_sql} WHERE id={$user_id};";
            mysqli_query($conn,$sql);
        }
        else{
            echo "incorrect";
        }

        

    }

    //=====Email Validation======//
    if($type=='validate_email'){   
        $email = strip_tags(mysqli_real_escape_string($conn,$_POST['email']));
        if(!empty($email)){
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                echo "no";
            }
            else{
                echo "valid";
            }
        }
    }

    //=====Insert Register======//
    if($type=='insert_register'){
        $name = strip_tags(mysqli_real_escape_string($conn,$_POST['name']));
        $email = strip_tags(mysqli_real_escape_string($conn,$_POST['email']));
        $mobile = strip_tags(mysqli_real_escape_string($conn,$_POST['mobile']));
        $pass = strip_tags(mysqli_real_escape_string($conn,($_POST['password'])));
        $date = date("d M, Y  h:i:s");

        $sql ="SELECT * FROM user WHERE email='{$email}'";
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){
            echo "exist";
        }
        else{
            $sql_insrt = "INSERT INTO user(name,email,mobile,added_on,img,password)
                VALUES('{$name}','{$email}','{$mobile}','{$date}','pp.jpg','{$pass}');";
            if(mysqli_query($conn,$sql_insrt)){
                echo "done";
            }
        }
    }

    //=====Forgot Passowrd======//
    if($type=='forgot_pass'){
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $sql ="SELECT * FROM user WHERE email='{$email}'";
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){
        
            $otp=rand(1111,9999);
            $_SESSION['EMAIL_OTP']=$otp;
            $html="<b><br><br><b>$otp is your otp</b><br><br>Please dont't share another.This Code helps to make your new password.";
            
            include('smtp/PHPMailerAutoload.php');
            $mail=new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host="smtp.sendgrid.net";
            $mail->Port=587;
            $mail->SMTPSecure="TLS";
            $mail->SMTPAuth=true;
            $mail->Username="MaasuquE";
            $mail->Password="1m2a3s4U123456789!";
            $mail->SetFrom("masukmia94@gmail.com");
            $mail->addAddress($email);
            $mail->IsHTML(true);
            $mail->Subject="New OTP";
            $mail->Body=$html;
            $mail->SMTPOptions=array('ssl'=>array(
                'verify_peer'=>false,
                'verify_peer_name'=>false,
                'allow_self_signed'=>false
            ));
            if($mail->send()){
                echo "done";
            }else{
                echo "failed";
            }

        }
        else{
            echo "not";
        }
    }

    if($type=='update_forgot_pass'){
        $pass = mysqli_real_escape_string($conn,$_POST['pass']);
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        if(isset($_POST['rdo_val'])){
            $rdo_val = mysqli_real_escape_string($conn,$_POST['rdo_val']);
        }else{
            $rdo_val ='';
        }
        
        $sql="UPDATE user SET password='{$pass}' WHERE email='{$email}'";
        if(mysqli_query($conn,$sql)){
            if($rdo_val=='stay'){
                $sql_lg = "SELECT * FROM user WHERE email='{$email}' AND password='{$pass}'";
                $res_lg = mysqli_query($conn,$sql_lg);
                if(mysqli_num_rows($res_lg) > 0){
                    while($row=mysqli_fetch_assoc($res_lg)){
                        $_SESSION['USER_LOGIN'] = 'yes';
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['username'] = $row['name'];
                        $_SESSION['alert']="Login Successful!";
                        $_SESSION['alert_code']="success";
                    }
                    echo "stay";
                    
                }
                else{
                    echo "failed";
                }
            }
            else{
                echo "stay_not";
            }
        }
        else{
            echo "failed";
        }
    }

    /// ====Discount Coupon ====////
    if($type=='discount_coupon'){
        $code = mysqli_real_escape_string($conn,$_POST['code']);
        $sql = "SELECT * FROM coupon WHERE coupon ='{$code}'";
        $res =mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){
            $row = mysqli_fetch_assoc($res);
            if($row['status']==1){
                $_SESSION['discount']=$row['discount'];
                $res_ds = mysqli_query($conn,"SELECT * FROM  cart JOIN product ON cart.product_id=product.product_id");
                if(mysqli_num_rows($res_ds)>0){
                    $sub_total=0;
                    while($row_ds=mysqli_fetch_assoc($res_ds)){
                        $sub_total+=($row_ds['price']*$row_ds['cart_qty']);
                    }

                    $html='<div class="order-details__count">
                    <div class="order-details__count__single">
                        <h5>sub total</h5>
                        <span class="price">&#2547; '.$sub_total.'</span>
                    </div>
                    <div class="order-details__count__single">
                        <h5>Deliver Charge</h5>
                        <span class="price">&#2547; 60</span>
                    </div>
                    <div class="order-details__count__single" id="discount_manage">
                        <h5>Discount</h5>
                        <span class="price">-'.$row['discount'].'%</span>
                    </div>
                    </div>
                    <div class="ordre-details__total">
                        <h5>Order total</h5>
                        <span class="price">&#2547;';
                        $sub_total=$sub_total+60;
                            $disc=$row['discount'];
                            $sub_total=$sub_total*((100-$disc)/100);
                            $html.=''.$sub_total.'</span>
                    </div>';
                    echo $html;
                }
            }
            else{
                echo "expired";
            }
        }
        else{
            echo "not found";
        }
    }

    ////// ------Sorting Category------//////
    if($type=='sort_cat'){
        $cid=mysqli_real_escape_string($conn,$_POST['cid']);
        $sort=mysqli_real_escape_string($conn,$_POST['sort_id']);
        $city=mysqli_real_escape_string($conn,$_POST['city']);
        $brand=mysqli_real_escape_string($conn,$_POST['brand']);
        
        $high_selected="";
        $new_selected="";
        $low_selected="";
        $sub_cat_sql ="";
        $def_selected="";
        $brand_sql="";
        $city_sql="";
        
        if($cid!=''){
            $cat_sql=" WHERE product.category={$cid}";
            if($brand!=''){
                $brand_sql=" AND brand.brand_name='{$brand}'";
            }
            if($city!=''){
                $city_sql=" AND brand.city='{$city}'";
            }
        }
        else{
            $cat_sql="";
            if($brand!=''){
                $brand_sql=" WHERE brand.brand_name='{$brand}'";
                if($city!=''){
                    $city_sql=" AND brand.city='{$city}'";
                }
            }
            if($brand==''){
                $brand_sql="";
                if($city!=''){
                    $city_sql=" WHERE brand.city='{$city}'";
                }
            }
        }

        if($sort=='default'){
            $sort_sql=" ORDER BY product.product_id ASC";
        }
        elseif($sort=='high_price'){
            $sort_sql=" ORDER BY product.price DESC";
            $high_selected="selected";
        }
        elseif($sort=='low_price'){
            $sort_sql=" ORDER BY product.price ASC";
            $low_selected="selected";
        }
        elseif($sort=='new'){
            $sort_sql=" ORDER BY product.price DESC";
            $new_selected="selected";
        }
        $sql="SELECT * FROM product 
        LEFT JOIN category ON product.category=category.category_id
        LEFT JOIN brand ON product.brand_id=brand.brand_id
         {$cat_sql}{$brand_sql}{$city_sql}{$sort_sql}";
        $res=mysqli_query($conn,$sql);
        if(mysqli_num_rows($res)>0){
        while($row=mysqli_fetch_assoc($res)) { 
                $html='<div class="col-md-3 col-lg34 col-sm-6 col-xs-12">
                    <div class="category">
                        <div class="ht__cat__thumb">
                            <a href="product-details.php?pid='.$row['product_id'].'">
                                <img src="admin/upload/'.$row['img'].'" alt="product images">
                            </a>
                        </div>
                        <div class="fr__hover__info">
                            <ul class="product__action">
                                <li><a href="wishlist.php?pid='.$row['product_id'].'"><i class="icon-heart icons"></i></a></li>

                                <li><a href="product-details.php?pid='.$row['product_id'].'"><i class="icon-handbag icons"></i></a></li>

                                <li><a href="#"><i class="icon-shuffle icons"></i></a></li>
                            </ul>
                        </div>
                        <div class="fr__product__inner">
                            <h4><a href="product-details.php?pid='.$row['product_id'].'">'.$row['product_name'].'</a></h4>
                            <ul class="fr__pro__prize">
                                <li class="old__prize">$'.$row['mrp'].'</li>
                                <li>$'.$row['price'].'</li>
                            </ul>
                        </div>
                    </div>
                </div>';
                 echo $html;
                 } 
                }
                else{
                    echo '<h2 align="center">Data Not Found.</h2>';
                }
    }

    ////------COMENT SECTION-----//////

    if($type=='product_comment'){

        if(!isset($_SESSION['user_id'])){
            echo "not logged";
            }
            else{
                $user_id = $_SESSION['user_id'];
                $pid = $_POST['pid'];
                $comment = mysqli_real_escape_string($conn,$_POST['comment']);
                $date = date("Y-m-d h:i:sa");
                $sql = "INSERT INTO product_comment(product_id,comment,comment_date,user_id)
                        VALUES({$pid},'{$comment}','{$date}',{$user_id})";
                if(mysqli_query($conn,$sql)){
                   commentPage();
                }
            }
    }
    
    ////----DLELETE COMMENT----////

    if($type=='delete_comment'){
        $cmnt_id=$_POST['cid'];
        $user_id=$_SESSION['user_id'];
        $sql = "DELETE FROM product_comment WHERE comment_id = {$cmnt_id} AND user_id={$user_id}";
        if(mysqli_query($conn,$sql)){
            commentPage();
        }

    }

    ////------MODAL LOGIN----////
    if($type=='modal_login'){
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $pass = mysqli_real_escape_string($conn,$_POST['pass']);
        
        $res=mysqli_query($conn,"SELECT * FROM user WHERE email='{$email}' AND password='{$pass}'");
        if(mysqli_num_rows($res)>0){
            $row=mysqli_fetch_assoc($res);
            $_SESSION['USER_LOGIN'] = 'yes';
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['username'] = $row['name'];
            echo "done";
        }
        else{
            echo "no";
        }
    }

    ////-------COMMENT LIKE & DISLIKE------//////
    if($type=='like_dislike'){
        $like_updt ="";
        $dislike_updt="";
        $id=mysqli_real_escape_string($conn,$_POST['id']);
        $cid = $_POST['cid'];
        if($id=='like'){
            $like_updt = " comment_like=comment_like+1";
        }
        elseif($id=='dislike'){
            $dislike_updt = " comment_dislike=comment_dislike+1";
        }

        $sql = "UPDATE product_comment SET {$like_updt}{$dislike_updt} WHERE comment_id={$cid}";
        if(mysqli_query($conn,$sql)){
            commentPage();
        }
        else{
            echo "failed";
        }
    }

    ///----Order Rating----///

    if($type=='order_rating'){
        $result="";
        $rate=$_POST['rate'];
        $user_id = $_SESSION['user_id'];
        foreach($_SESSION['order_pid'] as $key=>$value){
            $coin_updt = "UPDATE user SET user_coin=user_coin+100 WHERE id={$user_id}";
            mysqli_query($conn,$coin_updt);
            $res_q=mysqli_query($conn,"SELECT * FROM product_rating WHERE product_id={$value}");
            
            if(mysqli_num_rows($res_q)>0){
                $row_rate=mysqli_fetch_assoc($res_q);
                $persons=$row_rate['1_star']+$row_rate['2_star']+$row_rate['3_star']+$row_rate['4_star']+$row_rate['5_star']+1;
                $rating=(1*$row_rate['1_star']+2*$row_rate['2_star']+3*$row_rate['3_star']+4*$row_rate['4_star']+5*$row_rate['5_star']+$rate)/$persons;
                $sql_updt="UPDATE product_rating SET {$rate}_star={$rate}_star+1,rate={$rating} WHERE product_id={$value}";
                
                if(mysqli_query($conn,$sql_updt)){
                    $result="done";
                }
            }
            else{
                $sql_insrt = "INSERT INTO product_rating(product_id,{$rate}_star,rate)
                    VALUES({$value},1,{$rate})";
                if(mysqli_query($conn,$sql_insrt)){
                    $result="done";
                }
            }
            echo $result;

        }
        unset($_SESSION['order_pid']);
    }

    ///----Quantity Update---///

    if($type=='quantity_update'){
        $sign=mysqli_real_escape_string($conn,$_POST['sign']);
        $amount_type=mysqli_real_escape_string($conn,$_POST['amount_type']);
        if($amount_type=='coin'){
            $atype =" AND cart.buy_type='coin'";
        }
        else{
            $atype =" AND cart.buy_type='cart'";
        }
        $all_coin=0;
        $plus="";
        $minus="";
        $cid=$_POST['cid'];
        $val = $_POST['val'];
        if($sign=='+'){
            $qty_sql="cart_qty=cart_qty+1";
        }
        if($sign=='-'){
            $qty_sql="cart_qty=cart_qty-1";
        }
        $sql="UPDATE cart SET {$qty_sql} WHERE cart_id={$cid}";
        if(mysqli_query($conn,$sql)){
            $user_id = $_SESSION['user_id'];
            $sql_cp="SELECT * FROM cart JOIN product ON cart.product_id=product.product_id
            WHERE cart.user_id={$user_id}{$atype}
            ORDER BY cart.cart_id DESC";
            $res_cp=mysqli_query($conn,$sql_cp); 
            if(mysqli_num_rows($res_cp) > 0){
                while($row_cp=mysqli_fetch_assoc($res_cp)) {
                    $html='<tr>
                    <td class="product-thumbnail"><a href="product-details.php?pid='.$row_cp['product_id'].'"><img src="admin/upload/'.$row_cp['img'].'" alt="product img" /></a></td>
                    <td class="product-name"><a href="product-details.php?pid='.$row_cp['product_id'].'">'.$row_cp['product_name'].'</a>
                        
                    </td>
                    <td class="product-price"><span class="amount">';
                    if($amount_type=='coin'){
                        $price_ic ='<i class="fas fa-coins"></i> ';
                        $price=$row_cp['coin'];
                        $price_t = $price*$row_cp['cart_qty'];
                        $all_coin +=$price_t;
                    }
                    else{
                        $price_ic='&#2547; ';
                        $price=$row_cp['price'];
                        $price_t =$price*$row_cp['cart_qty'];
                    }
                    $html.=''.$price_ic.''.$price.'</span></td>
                    <td class="product-quantity">
                        <div class="cart-plus-minus">';
                            $plus="'+','{$row_cp['cart_id']}','{$amount_type}'";
                            $minus="'-','{$row_cp['cart_id']}','{$amount_type}'";
                            if($row_cp['cart_qty']>1){
                            $html.='<div class="dec qtybutton" onclick="qty_btn('.$minus.')">-</div>';}
                                $html.='<input class="cart-plus-minus-box" id="qty" type="text" name="qtybutton" disabled="disabled" value="'.$row_cp['cart_qty'].'">';
                            if($row_cp['cart_qty']<$row_cp['qty']){
                            $html.='<div class="inc qtybutton" onclick="qty_btn('.$plus.')">+</div></div>';}
                    $html.='</td>
                    <td class="product-subtotal">';
                    
                     $html.=''.$price_ic.''.$price_t.'</td>
                    <td class="product-remove" onclick="delete_cart("'.$row_cp['cart_id'].'")"><a href="#"><i class="icon-trash icons"></i></a></td>
                </tr>
                <input type="hidden" id="all_coin" value="'.$all_coin.'">';
                echo $html;
                } 
            }
        }
        
        
    }

////// -----Delivery Boy Registation---////
if($type=='del_boy_reg'){
    $name=mysqli_real_escape_string($conn,$_POST['name']);
    
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $age=mysqli_real_escape_string($conn,$_POST['age']);
    $mobile=mysqli_real_escape_string($conn,$_POST['mobile']);
    $city=mysqli_real_escape_string($conn,$_POST['city']);
    $address=mysqli_real_escape_string($conn,$_POST['address']);
    $pass=mysqli_real_escape_string($conn,$_POST['pass']);
    $gender=mysqli_real_escape_string($conn,$_POST['gender']);
    $date =date("Y-m-d h:i:sa");
    $res=mysqli_query($conn,"SELECT * FROM delivery_boy WHERE del_boy_email='{$email}' OR mobile='{$mobile}'");
    if(mysqli_num_rows($res)>0){
        while($row=mysqli_fetch_assoc($res)){
            if($row['email']==$email){
                echo "email_exist";
            }
            elseif($row['mobile']==$mobile){
                echo "mobile_exist";
            }
        }

    }
    else{
        $sql="INSERT INTO delivery_boy(boy_name,del_boy_email,mobile,city,age,address,gender,password,img,boy_added_on) 
            VALUES('{$name}','{$email}','{$mobile}','{$city}','{$age}','{$address}','{$gender}','{$pass}','pp.jpg','{$date}')";
        
        if(mysqli_query($conn,$sql)){
            echo "done";
        }
    }
}

/////------Delivery boy Login---////
if($type=='del_boy_log'){
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $pass=mysqli_real_escape_string($conn,$_POST['pass']);
    $res=mysqli_query($conn,"SELECT * FROM delivery_boy WHERE email='{$email}' AND password='{$pass}'");
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $_SESSION['alert']="Login Successful as Delivery Boy";
        $_SESSION['alert_code']="success";
        $_SESSION['del_boy']=$row['boy_name'];
        $_SESSION['del_boy_id']=$row['del_boy_id'];
        echo "done";
    }
    else{
        echo "failed";
    }
}
//////---Coin Checkout---////
if($type=='coin_chk'){
    $coin =$_POST['coin']+300;
    $user_id = $_SESSION['user_id'];
    $res = mysqli_query($conn,"SELECT * FROM user WHERE user_coin>={$coin} AND id={$user_id}");
    if(mysqli_num_rows($res)>0){
        echo "ok";
    }
    else{
        echo "no";
    }
}

 ?>