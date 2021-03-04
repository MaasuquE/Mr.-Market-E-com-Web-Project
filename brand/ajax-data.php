<?php  
    include "config.php";
    session_start();
    date_default_timezone_set('Asia/Dhaka');
    $type=mysqli_real_escape_string($conn,$_POST['type']);

    function reloadPage(){
            include "config.php";
            $search="";
            if(isset($_POST['row'])){
                $rows=$_POST['row'];
            }
            else{
                $rows=10;
            }
            if(isset($_POST['val'])){
                $val = mysqli_real_escape_string($conn,$_POST['val']);

                $search =" AND (product.product_name LIKE '%{$val}%' || category.category_name LIKE '%{$val}%' || sub_category.sub_categories LIKE '%{$val}%')";
            }
            $bran_id = $_SESSION['brand_id'];
            $sql ="SELECT * FROM product LEFT JOIN category ON product.category=category.category_id 
            LEFT JOIN sub_category ON product.sub_cat_id=sub_category.sub_id
            WHERE product.brand_id={$bran_id}{$search} LIMIT {$rows}";
            $res=mysqli_query($conn,$sql);
            if(mysqli_num_rows($res)>0){
                $i=1;
                while($row=mysqli_fetch_assoc($res)){
                    $html='<tr>
                    <td>'.$i++.'</td>
                    <td>'.$row['product_id'].'</td>
                    <td>'.$row['product_name'].'</td>
                    <td>'.$row['category_name'].'</td>
                    <td>'.$row['sub_categories'].'</td>
                    <td>'.$row['qty'].'</td>
                    <td>'.$row['price'].'</td>
                    <td>'.$row['discount'].'%</td>
                    <td><img src="../admin/upload/'.$row['img'].'" alt=""></td>
                    <td class="sts_td">'; if($row['pdt_sts']==1){
                        $html.='<a href="" onclick="brand_sts('.$row['product_id'].',1)"><i class="fas fa-toggle-on"></i></a>';
                         }else{ 
                            $html.='<a onclick="brand_sts('.$row['product_id'].',1)"><i class="fas fa-toggle-off"></i></a>';
                        }
                        $html.='</td>
                    <td class="edit_td"><a href=""><i class="far fa-edit"></i></a></td>
                    <td class="dlt_td"><button type="button" onclick="dlt_btn('.$row['product_id'].')">Delete</button></td>
                     </tr>';

                     echo $html;
                    
                } 
                  
                
            }
    }


    ////------Register Brand -------/////
    
    if($type=='brand_register'){
        $err='';
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['pass']);
        $brand_cat= mysqli_real_escape_string($conn,$_POST['brand_cat']);
        $brand_name= mysqli_real_escape_string($conn,$_POST['brand']);
        $city= mysqli_real_escape_string($conn,$_POST['city']);
        $licence= mysqli_real_escape_string($conn,$_POST['lcn']);
        $address= mysqli_real_escape_string($conn,$_POST['address']);
        $logo= mysqli_real_escape_string($conn,$_POST['logo']);
        $logo=basename($logo);
        $date = date('Y-m-d H:i:s');

        $res_qry = mysqli_query($conn,"SELECT * FROM brand");
        if(mysqli_num_rows($res_qry)>0){
            while($row_qry = mysqli_fetch_assoc($res_qry)){
                if($row_qry['user_name']==$username){
                    $err= "username_ex";
                }
                else if($row_qry['email']==$email){
                    $err =  "email_ex";
                }
                else if($row_qry['city']==$city && $row_qry['address']==$address){
                    if($row_qry['brand_name']==$brand_name){
                        $err = "shop_ex";
                    }
                    else{
                    $err = "location_ex";
                    } 
                }
            }
        }
        if($err==''){
                $sql_insert="INSERT INTO brand(user_name,email,brand_name,brand_cat,city,licence,address,password,added_on,brand_logo,brand_sts)
                VALUES('{$username}','{$email}','{$brand_name}','{$brand_cat}','{$city}','{$licence}','{$address}','{$password}','{$date}','{$logo}',0)";
                    if(mysqli_query($conn,$sql_insert)){
                        echo "done";
                    }
        }
        echo $err;
    }

    /////--------Login Section -----/////

    if($type=='brand_login'){
        $username=mysqli_real_escape_string($conn,$_POST['username']);
        $pass = mysqli_real_escape_string($conn,$_POST['pass']);

        $sql = "SELECT * FROM brand WHERE user_name='{$username}' AND password = '{$pass}'";
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res)>0){
            $row = mysqli_fetch_assoc($res);
            if($row['brand_sts']==1){
                $_SESSION['login']='yes';
                $_SESSION['username']=$username;
                $_SESSION['brand_id']=$row['brand_id'];
                $_SESSION['brand_name']=$row['brand_name'];
                echo "done";
            }
            else{
                echo "deactive";
            }
            
        }
        else{
            echo "failed";
        }
    }


    ////-------Logout Section ------////

    if($type=='logout_brand'){
        session_unset();
        session_destroy();
        echo "done";
    }

    ////------Sub Category-----/////

        if($type=='sub_cat'){
        $cat_id =mysqli_real_escape_string($conn,$_POST['cat_id']);
        $sub_cat_id =mysqli_real_escape_string($conn,$_POST['sub_cat_id']);
        

        $sql = "SELECT * FROM sub_category WHERE category_id={$cat_id} AND status='1'";
        $res=mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){
            $html='';
            while($row=mysqli_fetch_assoc($res)){
                if($row['sub_id']==$sub_cat_id){
                    $html = "<option value=".$row['sub_id']." selected>".$row['sub_categories']."</option>";
                }else{
                    $html = "<option value=".$row['sub_id'].">".$row['sub_categories']."</option>";
                }
                
                echo $html;
            }
            
        }
        else{
            echo "<option value=''>Sub categories not found</option>";
        }
    }
    
    ////-----Brand Satus----////

    if($type=='brand_status'){
        $pid=mysqli_real_escape_string($conn,$_POST['pid']);
        $sts=mysqli_real_escape_string($conn,$_POST['sts']);
        if($sts==0){
            $sts=1;
        }
        else{
            $sts=0;
        }
        
        $sql_updt="UPDATE product SET pdt_sts={$sts} WHERE product_id={$pid}";
        if(mysqli_query($conn,$sql_updt)){
           
            reloadPage();
                    
        }
    }

    ///-----DELETE ROW----////
    if($type=='delete_row'){
        $pid=mysqli_real_escape_string($conn,$_POST['pid']);
        $sql_dlt ="DELETE FROM product WHERE product_id={$pid}";
        if(mysqli_query($conn,$sql_dlt)){
            reloadPage();
        }
    }

    ////-----Show Rows---///
    if($type=='show_rows'){
       reloadPage();
    }

    /////---Search Product---///

    if($type=='search_pdt'){
        
          reloadPage();
          
    }

    ////----Order Delete--///
    if($type=='order_delete'){
        $oid = $_POST['oid'];
        $sql_dlt = "DELETE FROM buy WHERE buy_id={$oid}";
        if(mysqli_query($conn,$sql_dlt)){
            $bran_id = $_SESSION['brand_id'];
            $sql ="SELECT * FROM buy 
            LEFT JOIN product ON buy.product_id=product.product_id
            LEFT JOIN category ON product.category=category.category_id 
            LEFT JOIN sub_category ON product.sub_cat_id=sub_category.sub_id
            WHERE product.brand_id={$bran_id}";
            $res=mysqli_query($conn,$sql);
            if(mysqli_num_rows($res)>0){
                $i=1;
                while($row=mysqli_fetch_assoc($res)){
                    $html='<tr>
                    <td>'.$i++.'</td>
                    <td>'.$row['product_id'].'</td>
                    <td>'.$row['product_name'].'</td>
                    <td>'.$row['category_name'].'</td>
                    <td>'.$row['sub_categories'].'</td>
                    <td>'.$row['sell_qty'].'</td>
                    <td>'.$row['price'].'</td>
                    <td><img src="../admin/upload/'.$row['img'].'" alt=""></td>
                    <td class="dlt_td"><button type="button" onclick="dlt_btn('.$row['product_id'].')">Delete</button></td>
                     </tr>';

                     echo $html;
                    
                } 
                  
                
            }
        }
    }
?>