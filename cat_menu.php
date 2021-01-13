<?php  
    include "config.php";
    $cat_id=$_POST['cid'];
    $sql="SELECT * FROM sub_category WHERE category_id={$cat_id}";
    $res=mysqli_query($conn,$sql);
    if(mysqli_num_rows($res) > 0){
        $html='';
        while($row=mysqli_fetch_assoc($res)){
            
                $html='<li><a href="#">'.$row['sub_categories'].'</a></li>';
                echo $html;
            
        }
        
    }
?>