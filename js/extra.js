function send_quantity(pid){
    
    var qty = jQuery("#qty").val();
    alert(pid);

    jQuery.ajax({

        url:'send_qty.php',
        type:'post',
        data:{quantity:qty, pdt_id:pid},
        success:function(result){
        }


    });

}


function send_to_cart(pid,type){
    
    var qty = jQuery(".sin__desc #qty").val();
    var size = jQuery('.select__size').val();
    if(typeof(size)=='undefined'){
        size='xl';
    }
    if(typeof(qty)=='undefined'){
        qty='1';
    }
    jQuery.ajax({

        url:'product-insert.php',
        type:'post',
        data:{quantity:qty, pdt_id:pid,type:type,size:size},
        success:function(result){
            
            if(result=='exist'){
                alert('This product already exist.');
            }
        }


    });
}
function checkout_done(type){
    jQuery('.field_error').html('');
    var name = jQuery(".bilinfo #name").val();
    var street = jQuery(".bilinfo #street").val();
    var house = jQuery(".bilinfo #house").val();
    var city = jQuery(".bilinfo #city").val();
    var post_code =jQuery(".bilinfo #post_code").val();
    var email = jQuery(".bilinfo #email").val();
    var phn =jQuery(".bilinfo #phn").val();
    var address =street+","+house+","+city+" - "+post_code;
    var payment_type = document.getElementsByName('payment');
    var payment ='';
    for(var i=0;i<payment_type.length;i++){
        if(payment_type[i].checked){
            payment = payment_type[i].value;
        }
    }
    var is_error ='';

    if(name==""){
        jQuery('#name_error').html('Please Enter name');
        is_error ='yes';
    }
    if(street==''){
        jQuery("#street_error").html('Please Enter Street address');
        is_error ='yes';
    }
    if(city==''){
        jQuery("#city_error").html('Please Enter city');
        is_error ='yes';
    }
    if(post_code==''){
        jQuery("#code_error").html('Please Enter post code');
        is_error ='yes';
    }
    if(email==''){
        jQuery("#email_error").html('Please Enter email');
        is_error ='yes';
    }
    if(phn==''){
        jQuery("#phn_error").html('Please Enter Phone Number');
        is_error ='yes';
    }
    if(payment==''){
        jQuery("#payment_error").html('Please Select Method');
        is_error ='yes';
    }
    if(is_error==''){
        jQuery.ajax({
            url:'checkout-done.php',
            type:'post',
            data:{name:name, address:address, email:email, phone:phn, payment:payment,type:type},
            success:function(result){
                if(result=='success'){
                    window.location.href='my_order.php';
                } 
            }

        });
    }
        
}
function sort_product(cat_id){
    var sort_type = jQuery("#sort_pdt_id").val();
    var brand=$('.brand_sort select').val();
    var city = $('.city_sort select').val();
    var type="sort_cat";
    if(sort_type!=''){
        $.ajax({
            url:'update_data.php',
            type:'post',
            data:{cid:cat_id,sort_id:sort_type,brand:brand,city:city,term:type},
            success:function(result){
               $('#grid-view').html(result);
            }
        });
    }
    
}


function cat_menu(cid){
    jQuery.ajax({
        url:'cat_menu.php',
        type:'post',
        data:{cid:cid},
        success:function(result){
            jQuery('#sub_menu').html(result);
            jQuery('#sub_menu').show();
           // $("ul.top li").children("ul.sub_menu").slideDown('fast').show();
        }
    });
}

$(document).ready(function () {
    $("ul.top li").hover(function () { //When trigger is hovered...
        var cid = $(this).val();
        cat_menu(cid);
        $(this).children("ul.sub_menu").slideDown('fast').show();
    }, function () {
        $(this).children("ul.sub_menu").slideUp('slow');
    });
});

//===Delete cart===///
function delete_cart(cart_id){
    swal({
        title: "Are you sure?",
        text: "you will not be able to recover this imaginary file!",
        icon: "warning", 
        dangerMode: true,
        buttons:{
            cancel: {
              text: "Cancel",
              value: null,
              visible: true,
              closeModal: true,
            },
            confirm: {
              text: "Yes, delete it!",
              value: true,
              visible: true,
              closeModal: true,
            }
          },
        
          
      })
      .then((willDelete) => {
        if (willDelete) {
            jQuery.ajax({
                url:'delete_cart.php',
                type:'post',
                data:{cart_id:cart_id},
                success:function(result){
                    swal("Poof! File has been deleted!", {
                        icon: "success",
                      });
                    //jQuery('.delete').parents('tr').last().hide();
                    location.reload();   
                }
            });
          
        }else {
          swal({
                title:"Your file is safe!",
                icon: "info",
          });
        }
      });

 }

 function chage_pass(){
     jQuery('#change_pass').slideDown(1000);
 }
 $('.emp-profile input').focusin(function(){
    $(this).css('background','white');
 }).blur(function(){
    $(this).css('background','#c9e0d58c none repeat scroll 0 0');
    setTimeout(function(){ 
        $('.field_error').html(''); 
     }, 5000);
 });

 function update_profile(uid){
     jQuery('.field_error').html('');
     var name=jQuery('#name').val();
     var email=jQuery('#profile_email').val();
     var phn=jQuery('#phn').val();
     var old_pass =jQuery('#old_pass').val();
     var new_pass1=jQuery('#new_pass1').val();
     var new_pass2=jQuery('#new_pass2').val();
     var pass='';
     var is_error='';
     if(old_pass=='' && new_pass1=='' && new_pass2==''){
         location.href='profile.php';
     }
    else{
        if(name==''){
            jQuery('#name_error').html('please fill out name field.');
            is_error='yes';
        }
        if(email==''){
           jQuery('#email_error').html('please fill out email field.');
           is_error='yes';
       }
       if(phn==''){
           jQuery('#phn_error').html('please fill out mobile field.');
           is_error='yes';
       }
       // if(old_pass==''){
       //     jQuery('#old_pass_error').html('please fill out mobile field.');
       //     is_error='yes';
       // }
       if(new_pass1 !='' || new_pass2 !=''){
           jQuery('#change_pass').show();
           if(new_pass1==''){
               jQuery('#pass1_error').html('please fill out password field.')
               is_error='yes';
           }
           else if(new_pass2==''){
               jQuery('#pass2_error').html('please fill out password field.')
               is_error='yes';
           }
           else if(new_pass1 != new_pass2){
                   jQuery('#pass2_error').html('password not matched.')
                   is_error='yes';
               }
           else if(new_pass1 == new_pass2){
               pass=new_pass2;
           }
       }
   
       if(is_error==''){
           var profile_update="profile_update";
           jQuery.ajax({
               url:'update_data.php',
               type:'post',
               data:{uid:uid,term:profile_update,name:name,email:email,phn:phn,pass:pass,old_pass:old_pass},
               success:function(result){
                   if(result=='incorrect'){
                       jQuery('#old_pass_error').html('Incorrect Password.'); 
                   }
                   else{
                       location.href='profile.php';
                   }
               }
           });
       }
     }
     
 }
 function file_change(uid){
    var fd = new FormData();
    var files = $('#file')[0].files;
    
    // Check file selected or not
    if(files.length > 0 ){
       fd.append('file',files[0]);

       $.ajax({
          url: 'upload_profile.php',
          type: 'post',
          data: fd,
          contentType: false,
          processData: false,
          success: function(response){
            if(response != 0){
                $("#img").attr("src",response); 
                $(".preview img").show(); // Display image element
             }else{
                alert('file not uploaded');
             }
          },
       });
    }else{
       alert("Please select a file.");
    }
 }

jQuery('#register_site').hide();
$('.message a').click(function(){

    jQuery('#register_site').fadeIn('slow');
    jQuery('#login_site').fadeOut('slow');
});

 function validate_email(email){
     var term ="validate_email";
    jQuery.ajax({
        url:'update_data.php',
        type:'post',
        data:{email:email,term:term},
        success:function(result){
            if(result=='valid'){
                jQuery('#email_error, #forgot_email_error').html("<span style='color:#0c52ef'>Valid email address!</span>");
                jQuery('#email_otp_btn').show();
            }
            if(result=='no'){
                jQuery('#email_error, #forgot_email_error').html('That doesn\'t appear to be validated email');
                jQuery('#email_otp_btn').hide();
            }
            
        }
    });
 }

 $('#email, #forgot_email').focusin(function(){
    if($('#email').val() === ''){
        jQuery('#email_error').text('Go on, Enter a valid email');
        jQuery('#email_error').css("color","#e014da");
        
    }
    if($('#forgot_email').val() == ''){
        jQuery('#forgot_email_error').text('Go on, Enter a valid email');
        jQuery('#forgot_email_error').css("color","#e014da");
    }
 }).keyup(function(){
    if($('#email').val() == ''){
        jQuery('#email_error').text('Go on, Enter a valid email');
        jQuery('#email_error').css("color","#e014da");
        if($('#forgot_email').val() == ''){
            jQuery('#forgot_email_error').text('Go on, Enter a valid email');
            jQuery('#forgot_email_error').css("color","#e014da");
        }
        else{
            validate_email($('#forgot_email').val());
        }
        
    }
    
    else{
        validate_email($('#email').val());
        
    }
    
 }).blur(function(){
    if($('#email').val() == ''){
        jQuery('#email_error').text('Please enter a valid email'); 
    }
    if($('#forgot_email').val() == ''){
        jQuery('#forgot_email_error').text('Please enter a valid email');
    }
    else{
        validate_email($('#email').val());

        validate_email($('#forgot_email').val());
        
    }
    
 });

///======Register Insert====///
 function register_btn(){
     
     jQuery('.field_error').html('');
     jQuery('#email_error').css("color","red");
     var name=jQuery('#register_site #name').val();
     var email=jQuery('#reg_email').val();
     var mobile=jQuery('#phn').val();
     var password=jQuery('#password_reg').val();
     var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
     var is_error='';
    if(name==''){
        jQuery('#name_error').html('please fill out name field.');
        is_error='yes';
    }
    if(email==''){
       jQuery('#email_error').html('please fill out email field.');
       is_error='yes';
   }
   if(!emailReg.test(email)){
        jQuery('#email_error').html('please enter valid email.');
        is_error='yes';
   }
   if(mobile==''){
       jQuery('#phn_error').html('please fill out mobile field.');
       is_error='yes';
   }
   if(password==''){
    jQuery('#pass_error').html('please fill out password field.');
    is_error='yes';
    }
    if(is_error==''){
        var term="insert_register";
        jQuery.ajax({
            url:'update_data.php',
            type:'post',
            data:{term:term,name:name,email:email,mobile:mobile,password:password},
            success:function(result){
                if(result=='exist'){
                    jQuery('#email_error').html('Email already exist.');
                    
                }
                if(result=='done'){
                    jQuery('#register_site').slideUp("slow");
                    jQuery('#login_site').slideDown("slow");
                }
            }
        });
    }
 }

 ///====Eye button===////
 jQuery('#eye_show').hide();
$('.eye_btn').click(function(){
    
    var pass=jQuery('#password').attr('type');
    if(pass=='password'){
        jQuery('#password').attr('type','text');
        jQuery('#eye_show').show();
        jQuery('#eye_hide').hide();
        
    }else{
        jQuery('#password').attr('type','password');
        jQuery('#eye_hide').show();
        jQuery('#eye_show').hide();
    }
});


///==== Email & Mobile verification ====////
jQuery('#email_otp').hide();
jQuery('#email_verify').hide();
function email_sent_otp(){ 
    jQuery('#email').attr('width','50%');
    jQuery('#email_otp_btn').hide();
    jQuery('#email_error').html('Please wait.....');
    var email = jQuery('#email').val();
    var type='email';
    jQuery.ajax({
        url:'sent_otp.php',
        type:'post',
        data:{type:type,email:email},
        success:function(result){
            if(result=='done'){
                jQuery('#email_otp').show();
                jQuery('#email_verify').show();
                jQuery('#email_error').html('');
                jQuery('#email').prop('disabled', true);
                
            }
            else if(result=='exist'){
                jQuery('#email_error').html('Email already exist');
            }
            else{
                jQuery('#email_error').html('Please try after sometime');
                jQuery('#email').prop('disabled', false);
            }
        }
    });

    
}
jQuery('#register').attr('disabled','disabled');
function email_verify_otp(){
    jQuery('.field_error').html('');
    var otp =jQuery('#email_otp').val();
    if(otp==''){
        jQuery('#email_error').html('Enter the OTP.');
    }
    else{
        var type = 'verify_otp';
        jQuery.ajax({
            url:'sent_otp.php',
            type:'post',
            data:{otp:otp,type:type},
            success:function(result){
                if(result=='done'){
                    jQuery('#email_otp').hide();
                    jQuery('#email_verify').hide();
                    jQuery('#email_error').html('Email Verified.');
                    jQuery('#register').removeAttr('disabled');
                }
                else{
                    jQuery('#email_error').html('OTP invalid.');
                    jQuery('#register').attr('disabled','disabled');
                }
            }
        });
    }
}
/*function moblie_sent_otp(){
    jQuery('#msg').html('');
    var moblie = jQuery('#mobile').val();
    if(moblie==''){
        jQuery('#msg').html('Please enter mobile number');
    }else{
        jQuery.ajax({
            url:'sent_otp.php',
            type:'post',
            data:{phn:moblie,type:mobile},
            success:function(result){
                if(result==''){
                    alert('No'); 
                }
                else{
                    alert('Yes');
                }
                
            }
        });
        
    }
    
}
function moblie_verify_otp(){
    jQuery('#msg').html('');
    var otp = jQuery('#mobile_otp').val();
    if(otp==''){
        jQuery('#msg').html('Please enter OTP');
    }else{
        jQuery('.verify_otp').hide();
        jQuery('#test').html('Number Verified');
    }
    
}*/

///=====Forgot Password=====////

$('.forgot_pass').click(function(){
    jQuery('#login_container').css("opacity","0.05");
    jQuery('#login_site form').hide();
    jQuery('.pass_container').show('slow');
    
});
jQuery('#forgot_email_error').html('');
$('#otp_to_email').click(function(){
    var email = jQuery('#forgot_email').val();
    var btn = jQuery('#otp_to_email').text();
    var pass1 = jQuery('#newpss1').val();
    var pass2 = jQuery('#newpss2').val();
    jQuery('#newpss2').keyup(function(){
        if(jQuery('#newpss1').val()!='' && jQuery('#newpss2').val()!=''){
            if(jQuery('#newpss1').val()==jQuery('#newpss2').val()){
                jQuery('#newpass2_error').html('Great,Password matched').css('color','green');
                jQuery('.radio_btn').show();
            }
            else{
                jQuery('.radio_btn').hide();
                jQuery('#newpass2_error').html('Password not matched').css('color','red');
            }
        }
        else{
            jQuery('#newpass2_error').html('');
        }
        
    });
    if(btn=='Send OTP'){
        var type="forgot_pass";
        if(email==''){
            jQuery('#forgot_email_error').html('Please Enter your valid email');
        }
        else{
            jQuery('#forgot_email_error').html('Please wait......');
            jQuery.ajax({
                url:'update_data.php',
                type:'post',
                data:{email:email, term:type},
                success:function(result){
                    if(result=='not'){
                        jQuery('#forgot_email_error').html('Your email is not fount. Please try another'); 
                    }
                    if(result=='failed'){
                        jQuery('#forgot_email_error').html('Somthing wrong! please try after somtime.');
                    }
                    if(result=='done'){
                        jQuery('#otp_data').slideDown('slow');
                        jQuery('#otp_to_email').html('Verify OTP');
                        jQuery('#forgot_email_error').html('');
                    }
                }
            });
        }
    }
    else if(btn=='Verify OTP'){
       var otp=jQuery('#forgot_otp').val();
       if(otp==''){
           jQuery('#forgot_otp_error').html('Please Enter the OTP');
       }
       else{
            var type = 'verify_otp';
            jQuery.ajax({
                url:'sent_otp.php',
                type:'post',
                data:{otp:otp,type:type},
                success:function(result){
                    if(result=='done'){
                        jQuery('#forgot_otp_error').html('');
                        jQuery('#email_data, #otp_data').hide();
                        jQuery('#newpass_data').show();
                        jQuery('#otp_to_email').html('Submit Password');
                    }
                    if(result=='failed'){
                        jQuery('#forgot_otp_error').html('OTP is invalid. please try valid otp');
                    }
                }
            });
        }
    }
    else if(btn=='Submit Password'){
        
         var pass = '';
        if(pass1==''){
            jQuery('#newpass1_error').html('Please fillup this field');
        }
        if(pass2 == ''){
            jQuery('#newpass2_error').html('Please fillup this field');
        }
        if(pass1 != '' && pass2 != ''){
            if(pass1==pass2){
                pass=pass2;
            }
            else{
                jQuery('#newpass2_error').html('Oops!,Password not matched').css('color','red');
            }
        }
        if(pass != ''){
            var rdo_val= $("input[type='checkbox']:checked").val();
            var term = 'update_forgot_pass';
            jQuery.ajax({
                url:'update_data.php',
                type:'post',
                data:{pass:pass,email:email,term:term,rdo_val:rdo_val},
                success:function(result){
                    if(result=='stay'){
                        location.href='index.php';
                    }
                    if(result=='stay_not'){
                        location.href='login.php';
                    }
                    if(result=='failed'){
                        jQuery('#newpass2_error').html('Something wrong! Please try after sometime.').css('color','red');
                    }
                }
            });
        }
    }
});

$('.close-btn').click(function(){
    jQuery('.pass_container').hide('slow');
    jQuery('#login_container').css("opacity","1");
    jQuery('#login_site form').show();
});

/// === Discount Coupon ===////
jQuery('#coupon_error').html('');
$('#discount_coupon').click(function(){
    setTimeout(function(){ 
        $('.field_error').html(''); 
        jQuery('#coupon_code').val('');
     }, 5000);
    var code = jQuery('#coupon_code').val();
    var type = "discount_coupon";
    if(code==''){
        jQuery('#coupon_error').html('Please Enter a valid code');
    }
    else{
        jQuery.ajax({
            url:'update_data.php',
            type:'post',
            data:{code:code,term:type},
            success:function(result){
                if(result=='not found'){
                    jQuery('#coupon_error').html('Your Code is Unavailable');
                }
                if(result=='expired'){
                    jQuery('#coupon_error').html('This Code is Expired.');
                }
                else{
                    $('.calc_dsc').html(result);
                    jQuery('.discount_site').hide();
                }
            }
        });
    }
});

// // $('.slick-track').animate({left:'100%'},5000);  
// setInterval(() => {
//     // $('.slick-track').css('left','-10%');
//     $('.slick-track').animate({left:'100%'},5000);     
// }, 100);
// setInterval(() => {
    
//     $('.slick-track').animate({left:'0%'},5000);  
    
// }, 5100);
// // setTimeout(() => {
    
// // }, 100);

$('.slick-slide').hover(function (){
    $('.slick-slide').stop();
});

/////----Add Comment----////

$('.add_comment input').focusin(function(){
    $('.add_comment input').animate({borderWidth:'2px'},0);
}).blur(function (){
    $('.add_comment input').animate({borderWidth:'1px'},0);
});


$('.add_comment i').click(function(){
    var pid = $('.add_comment #pid_cmnt').val();
    var comment = $('.add_comment #comment').val();
    var type = "product_comment";
    if(comment!=''){
        $.ajax({
            url:'update_data.php',
            type:'post',
            data:{pid:pid,comment:comment,term:type},
            success:function(result){
                if(result=='not logged'){
                   $('.modal').show();
                }
                else{
                    $('#show_comment').html(result);
                }
                $('.add_comment #comment').val('');
            }
        });
    }
});

////----DELETE COMMENT----////
function delete_comment(cmnt_id,pid){
    var type ="delete_comment";
    $.ajax({
        url:'update_data.php',
        type:'post',
        data:{pid:pid,cid:cmnt_id,term:type},
        success:function(result){
            $('#show_comment').html(result);
        }
    });
}

/////------LOGIN MODAL----////
var modal = document.getElementById("myModal");

var span = document.getElementsByClassName("close")[0];

span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
///// ----LOGIN WITH MODAL----/////
function modal_login(){
    $('.field_error,#login_error').html('');
    var email = $('#email').val();
    var pass = $('#pass').val()
    var type='modal_login';
    is_error="";
    if(email==''){
        $('#email_error').html('Please Enter a valid email');
        is_error='yes';
    }
    if(pass==''){
        $('#pass_error').html('Please Enter the password');
        is_error='yes';
    }
    if(is_error==''){
        $.ajax({
            url:'update_data.php',
            type:'post',
            data:{email:email,pass:pass,term:type},
            success:function(result){
                if(result=='done'){
                    location.reload();
                }
                if(result=='no'){
                    $('#login_error').html('Email info incorrect!');
                }
            }
        });
    }
}

//// ------LIKE & DISLIKE----////
function like_dislike(id,cid,pid){
    var type='like_dislike';
    alert(id);
    $.ajax({
        url:'update_data.php',
        type:'post',
        data:{cid:cid,id:id,pid:pid,term:type},
        success:function(result){
            $('#show_comment').html(result);
        }
    });
}


///------Order Rating Modal---////
$(document).ready(function(){
    $('#stars li').on('mouseover', function(){
      var onStar = parseInt($(this).data('value'), 10); 
      $(this).parent().children('li.star').each(function(e){
        if (e < onStar) {
          $(this).addClass('hover');
        }
        else {
          $(this).removeClass('hover');
        }
      });
      
    }).on('mouseout', function(){
      $(this).parent().children('li.star').each(function(e){
        $(this).removeClass('hover');
      });
    });
    
    
    /* 2. Action to perform on click */
    $('#stars li').on('click', function(){
      var onStar = parseInt($(this).data('value'), 10);
      var stars = $(this).parent().children('li.star');
      
      for (i = 0; i < stars.length; i++) {
        $(stars[i]).removeClass('selected');
      }
      
      for (i = 0; i < onStar; i++) {
        $(stars[i]).addClass('selected');
      }
      
      
      var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
      var msg = "";

      if(ratingValue>0){
          var type = "order_rating";
          $.ajax({
              url:'update_data.php',
              type:'post',
              data:{rate:ratingValue,term:type},
              success:function(result){
                if (ratingValue > 1) {
                    msg = "Thanks! You rated this " + ratingValue + " stars.";
                }
                else {
                    msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
                }
                responseMessage(msg);
                $('.order_rating #myModal').fadeOut(1500);
              }
          });
      }
      
      
    });
    
    
  });
  
  
  function responseMessage(msg) {
    $('.success-box').fadeIn(200);  
    $('.success-box div.text-message').html("<span>" + msg + "</span>");
  }

 /*----------------------------
    	Cart Plus Minus Button
    ------------------------------ */
    

    function qty_btn(sign,cid,amount_type){
        var oldValue = $(".product-quantity .qtybutton").parent().find("input").val();
        var type="quantity_update"
        $.ajax({
            url:'update_data.php',
            type:'post',
            data:{term:type,val:oldValue,sign:sign,cid:cid,amount_type:amount_type},
            success:function(result){
                $('#cart_tbody').html(result);
            }
        });
    }

function details_qty_btn(sign,qty){
    $('.dec i').show();
    $('.inc i').show();
    var oldValue = $(".product-quantity .qtybutton").parent().find("input").val();
    if(sign==='+'){
        var newVal = parseFloat(oldValue) + 1;
        if(newVal>qty){
            $('.inc i').hide();
            newVal=oldValue;
        }
    }else {
        
        if (oldValue > 1) {
            var newVal = parseFloat(oldValue) - 1;
        } else {
            newVal = 1;
            $('.dec i').hide();
        }
    }
    $(".product-quantity .qtybutton").parent().find("input").val(newVal);
}
$('.del_boy_reg button, .del_reg .del_reg_btn').click(function(){
    $('#del_boy_reg .modal').show();
});
function del_boy_reg(){
    $('#del_boy_form input').css('border','1px solid black');
    var name=$('#del_boy_reg #del_name').val();
    var email=$('#del_boy_reg #email').val();
    var mobile=$('#del_boy_reg #mobile').val();
    var age=$('#del_boy_reg #age').val();
    var city=$('#del_boy_reg #city').val();
    var address=$('#del_boy_reg #address').val();
    var pass=$('#del_boy_reg #del_pass').val();
    var gender = $('input[type="radio"]:checked').val();
    var is_error='';
    if(name==''){
        $('#del_boy_reg #name').css('border','1px solid red');
        is_error='yes';
    }
    if(email==''){
        $('#del_boy_reg #email').css('border','1px solid red');
        is_error='yes';
    }
    if(mobile==''){
        $('#del_boy_reg #mobile').css('border','1px solid red');
        is_error='yes';
    }
    if(age==''){
        $('#del_boy_reg #age').css('border','1px solid red');
        is_error='yes';
    }
    if(city==''){
        $('#del_boy_reg #city').css('border','1px solid red');
        is_error='yes';
    }
    if(address==''){
        $('#del_boy_reg #address').css('border','1px solid red');
        is_error='yes';
    }
    if(pass==''){
        $('#del_boy_reg #pass').css('border','1px solid red');
        is_error='yes';
    }
    if(is_error==''){
        var type='del_boy_reg';
        $.ajax({
            url:'update_data.php',
            type:'post',
            data:{term:type,name:name,email:email,mobile:mobile,age:age,city:city,address:address,gender:gender,pass:pass},
            success:function(result){
                if(result=='email_exist'){
                    alert('Email Already Exist.');
                    $('#del_boy_reg #email').css('border','1px solid red');
                }
                if(result=='mobile_exist'){
                    alert('Mobile Already Exist.');
                    $('#del_boy_reg #mobile').css('border','1px solid red');
                }
                if(result=='done'){
                    alert('Registation Succesfull');
                    $('#del_boy_reg .modal').fadeOut(1000);
                }
                
            }
        });
    }
}

///------Delivery Boy Login---/////

$('.del_boy_log button').click(function(){
    $('#del_boy_log .modal').show();
});
$('#del_boy_log .modal-content .close').click(function(){
    $('#del_boy_log .modal').hide();
});
function del_boy_log(){
    $('#del_boy_log input').css('border','1.5px solid black');
    var email = $('#del_boy_log #email').val();
    var pass=$('#del_boy_log #pass').val();
    // alert(email+' == '+pass);
    var is_error='';
    if(email==''){
        $('#del_boy_log #email').css('border','1.5px solid red');
        $('#del_boy_log .log_error').html("Email is required.")
        is_error="yes";
    }
    if(pass==''){
        $('#del_boy_log #pass').css('border','1.5px solid red');
        $('#del_boy_log .log_error').html("Password is required.");
        is_error='yes';
    }
    if(is_error==''){
        var type='del_boy_log';
        $.ajax({
            url:'update_data.php',
            type:'post',
            data:{term:type,email:email,pass:pass},
            success:function(result){
                
                if(result=='done'){
                    location.href='index.php';
                }
                else if(result=='failed'){
                    $('#del_boy_log .log_error').html('Login Information in incorrect.');
                }
                else if(result=='deactive'){
                    $('#del_boy_log .log_error').html('Delivery boy is not active');
                }
            }
        });
    }
}

///----Coin Checked---////
function coin_chk(){
    var coin = $('#all_coin').val();
    var type="coin_chk";

    $.ajax({
        url:'update_data.php',
        type:'post',
        data:{coin:coin,term:type},
        success:function(result){
            if(result=='ok'){
                location.href='checkout.php?type=coin';
            }
            if(result=='no'){
                alert("Amount is influence");
            }
        }
    });
}