<?php  
    include "config.php";
    include "function.inc.php";

    $cat_id =get_string($conn,$_POST['cat_id']);
    $sub_cat_id =get_string($conn,$_POST['sub_cat_id']);
    

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

?>