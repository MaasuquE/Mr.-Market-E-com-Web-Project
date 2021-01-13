<?php include "config.php";
    include "toper.php";
    
  ?>
  <div class="welcome">
    <h1>Product</h1>
  </div>
  
  
<div class="product_table">
	  <div class="show_rows">
		<span>Show Rows: </span>
		<select name="rows" id="show_rows" onchange="show_rows()">
			<option value="10" selected>10</option>
			<option value="1" >1</option>
			<option value="2" >2</option>
			<option value="20">20</option>
			<option value="50">50</option>
			<option value="100">100</option>
		</select>
		</div>
  
  <?php 
  	$bran_id = $_SESSION['brand_id'];
	$sql ="SELECT * FROM buy 
    LEFT JOIN product ON buy.product_id=product.product_id
    LEFT JOIN category ON product.category=category.category_id 
	LEFT JOIN sub_category ON product.sub_cat_id=sub_category.sub_id
	WHERE product.brand_id={$bran_id}";
	$res =mysqli_query($conn,$sql);
	
 
 ?>
<table class="table">
	<thead>
		<tr>
			<th><h1>S.No</h1></th>
			<th><h1>Product ID</h1></th>
			<th><h1>Product</h1></th>
			<th><h1>Category</h1></th>
			<th><h1>Sub Category</h1></th>
			<th><h1>Quantity</h1></th>
			<th><h1>Price</h1></th>
			<th><h1>Image</h1></th>
			<th><h1>Action</h1></th>
		</tr>
	</thead>
	
	<tbody id="table_body">
	<?php $i=1;
	if(mysqli_num_rows($res)>0){
	 while($row=mysqli_fetch_assoc($res)) { ?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $row['product_id']; ?></td>
			<td><?php echo $row['product_name']; ?></td>
			<td><?php echo $row['category_name']; ?></td>
			<td><?php echo $row['sub_categories']; ?></td>
			<td><?php echo $row['sell_qty']; ?></td>
			<td><?php echo $row['price']; ?></td>
			<td><img src="../admin/upload/<?php echo $row['img']; ?>" alt=""></td>
			<td class="dlt_td"><button type="button" onclick="order_dlt_btn('<?php echo $row['buy_id']; ?>')">Delete</button></td>
		</tr>
	<?php } } ?>
	</tbody>
</table>
</div>

<?php include "footer.php"; ?>