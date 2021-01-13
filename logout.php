<?php  
    include "config.php";

    session_start();

    session_unset();
    

    session_destroy();
    unset($_SESSION['access_token']);

    header('location:index.php');


?>