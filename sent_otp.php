<?php 
    include "config.php";
    session_start();
    $type=mysqli_real_escape_string($conn,$_POST['type']);
    if($type=='email'){
        $email=mysqli_real_escape_string($conn,$_POST['email']);
        $check_user=mysqli_num_rows(mysqli_query($conn,"select * from user where email='$email'"));
        if($check_user>0){
            echo "exist";
            die();
        }
	
        $otp=rand(1111,9999);
        $_SESSION['EMAIL_OTP']=$otp;
        $html="$otp is your otp";
        
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

    if($type=='verify_otp'){
        $otp = $_POST['otp'];
        if($_SESSION['EMAIL_OTP']==$otp){
            echo "done";
        }
        else{
            echo "failed";
        }
    }

    //=====Mobile Verification====//
    /*if($type=='mobile'){
        $mobile='+88'.$_POST['phn'];
        $otp=rand(11111,99999);
        $_SESSION['mobile_otp']=$otp;
        $html="$otp is your otp.";

        $apiKey = urlencode('bFyZkg8kuNw-CGUSjjntHZb6IPj8XOnfXaNTbxImvC');
        $numbers = array($mobile);
        $sender = urlencode('OTP');
        $message = rawurlencode($html);
        $numbers = implode(',', $numbers);
        $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
        $ch = curl_init('https://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        echo "done";

    }*/

?>