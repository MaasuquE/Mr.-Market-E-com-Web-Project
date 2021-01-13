<?php  
include "config.php";
function get_string($conn,$str){
    if($str!=''){
        $str=trim($str);
        return strip_tags(mysqli_real_escape_string($conn,$str));
    }

    function get_product($conn,$type='',$limit= ''){
        $sql ="SELECT * FROM product";
    
        if($type='latest'){
            $sql .= " ORDER BY product_id DESC";
        }
        if($limit!=''){
            $sql .= " LIMIT $limit";
        }
    
        $res_pdt =mysqli_multi_query($conn,$sql) or die("Query Failed");
        return $res_pdt;
    }
}
?>