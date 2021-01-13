<?php  
  include "config.php";
  session_start();
  if(!isset($_SESSION['login'])){
    header("Location:{$hostname}/login.php");
  }
  $brand_id=$_SESSION['brand_id'];
  $res =mysqli_query($conn,"SELECT * FROM brand WHERE brand_id={$brand_id}");
  if(mysqli_num_rows($res)>0){
    $row=mysqli_fetch_assoc($res);
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Brand</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/all.min.css">
  <link rel="stylesheet" href="css/fontawesome.min.css">
</head>
<body>
<div class="container">
<div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
      <i class="fas fa-bars"></i>
    </a>
    <nav id="sidebar" class="sidebar-wrapper">
      <div class="sidebar-content">
        <div class="sidebar-brand">
          <a href="#">pro sidebar</a>
          <div id="close-sidebar">
            <i class="fas fa-times"></i>
          </div>
        </div>
        <div class="sidebar-header">
          <div class="user-pic">
            <img class="img-responsive img-rounded" src="upload/<?php echo $row['brand_logo']; ?>" alt="User picture">
          </div>
          <div class="user-info">
            <span class="user-name">
              <strong><?php echo strtoupper($_SESSION['username']); ?></strong>
            </span>
            <span class="user-role"><?php echo $_SESSION['brand_name']." (Brand)"; ?></span>
            <span class="user-status">
              <i class="fa fa-circle"></i>
              <span>Online</span>
            </span>
          </div>
        </div>
        <!-- sidebar-header  -->
        <!-- <div class="sidebar-search">
          <div>
            <div class="input-group">
              <input type="text" class="form-control search-menu" placeholder="Search...">
              <div class="input-group-append">
                <span class="input-group-text">
                <i class="fa fa-search" aria-hidden="true"></i>
                </span>
              </div>
            </div>
          </div>
        </div> -->
        <!-- sidebar-search  -->
        <div class="sidebar-menu">
          <ul>
            <li class="header-menu">
              <span>General</span>
            </li>
            <li class="sidebar-dropdown">
              <a href="index.php">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="sidebar-dropdown">
              <a href="#">
                <i class="fa fa-shopping-cart"></i>
                <span>Products</span>
                <span class="badge badge-pill badge-warning notification">3</span>
              </a>
              <div class="sidebar-submenu">
                <ul>
                <li>
                    <a href="product.php"> Product Table

                    </a>
                  </li>
                  <li>
                    <a href="add_product.php">Add Product

                    </a>
                  </li>
                  <li>
                    <a href="edit_product.php">Edit Product</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="sidebar-dropdown">
              <a href="order.php">
                <i class="far fa-gem"></i>
                <span>Order</span>
              </a>
            </li>
          </ul>
        </div>
        <!-- sidebar-menu  -->
      </div>
      <!-- sidebar-content  -->
      <div class="sidebar-footer">
        <a href="#">
          <i class="fa fa-bell"></i>
        </a>
        <a href="#">
          <i class="fa fa-envelope"></i>
        </a>
        <a href="#">
          <i class="fa fa-cog"></i>
          <span class="badge-sonar"></span>
        </a>
        <a onclick="logout_btn()">
          <i class="fa fa-power-off"></i>
        </a>
      </div>
    </nav>
 