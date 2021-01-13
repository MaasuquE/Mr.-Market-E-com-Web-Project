<?php
include "config.php";
//include autoload file from vendor folder
require 'vendor/autoload.php';


$fb = new Facebook\Facebook([
    'app_id' => '2748916005365919',
    'app_secret' => '056c578457f6499a4cf697efb37e9312',
    'default_graph_version' => 'v2.7'
 ]);


$helper = $fb->getRedirectLoginHelper();
$login_url = $helper->getLoginUrl("http://localhost/ecom/");
try {

    $accessToken = $helper->getAccessToken();
    if (isset($accessToken)) {
        $_SESSION['access_token'] = (string) $accessToken;
        
    }
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}

//now we will get users first name , email , last name
if (isset($_SESSION['access_token'])) {

    try {

        $fb->setDefaultAccessToken($_SESSION['access_token']);
        $res = $fb->get('/me?locale=en_US&fields=name,email');
        $user = $res->getGraphUser();
        $name= $user->getField('name');
        $email= $user->getField('email');
        $date = date('Y-m-d H:i:s');

        $sql = "INSERT INTO user(name,email,added_on,img) VALUES('{$name}','{$email}','{$date}','pp.jpg')";
        if(mysqli_query($conn,$sql)){
            $_SESSION['USER_LOGIN']='yes';
            $_SESSION['username']=$name;
            $_SESSION['email'] = $email;
            header("Location:{$hostname}/index.php");
        }
        else{
            header("Location:{$hostname}/login.php");
        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
}
