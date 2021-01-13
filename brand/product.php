<?php include "config.php";
    include "toper.php";
    
  ?>
  <div class="welcome">
    <h1>Product</h1>
  </div>
  
  
<div class="product_table">
   <div class='add_product'>
      <a href="add_product.php"><h4><i class="far fa-plus-square"></i> Add Product</h4></a>
  </div>
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
		<div class="search_box">
		  <span>Search: </span>
		  <input type="text" id="search_pdt" Placeholder="Text me...">
	  	</div>
  
  <?php 
  	$bran_id = $_SESSION['brand_id'];
	$sql ="SELECT * FROM product LEFT JOIN category ON product.category=category.category_id 
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
			<th><h1>Discount</h1></th>
			<th><h1>Image</h1></th>
			<th><h1>Status</h1></th>
			<th colspan="2"><h1>Action</h1></th>
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
			<td><?php echo $row['qty']; ?></td>
			<td><?php echo $row['price']; ?></td>
			<td><?php echo $row['discount']; ?>%</td>
			<td><img src="../admin/upload/<?php echo $row['img']; ?>" alt=""></td>
			<td class="sts_td"><?php if($row['pdt_sts']==1){?>
				<a href="" onclick="brand_sts('<?php echo $row['product_id'] ?>','1')"><i class="fas fa-toggle-on"></i></a>
				<?php }else{ ?>
					<a onclick="brand_sts('<?php echo $row['product_id'] ?>','0')"><i class="fas fa-toggle-off"></i></a>
				<?php }
			?></td>
			<td class="edit_td"><a href="edit_product.php?pid=<?php echo $row['product_id']; ?>"><i class="far fa-edit"></i></a></td>
			<td class="dlt_td"><button type="button" onclick="dlt_btn('<?php echo $row['product_id']; ?>')">Delete</button></td>
		</tr>
	<?php } } ?>
	</tbody>
</table>
</div>

<?php include "footer.php"; ?>