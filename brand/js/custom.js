
$(".sidebar-dropdown > a").click(function() {
    $(".sidebar-submenu").slideUp(200);
    if (
      $(this)
        .parent()
        .hasClass("active")
    ) {
      $(".sidebar-dropdown").removeClass("active");
      $(this)
        .parent()
        .removeClass("active");
    } else {
      $(".sidebar-dropdown").removeClass("active");
      $(this)
        .next(".sidebar-submenu")
        .slideDown(200);
      $(this)
        .parent()
        .addClass("active");
    }
  });
  
  $("#close-sidebar").click(function() {
    $(".page-wrapper").removeClass("toggled");
    $('.page-wrapper').css('margin-left','0');
    $('.search_box').css('top','35%');
  });
  $("#show-sidebar").click(function() {
    $(".page-wrapper").addClass("toggled");
    $('.page-wrapper').css('margin-left','19.5%');
    $('.search_box').css('top','29%');
  });
  

///End Brand Panel

function register_form(){
  $('#login').hide();
  $('#register').show();
  
}

///---------Register Section----------///

$('#register input').focus(function(){
    $(this).css('border','1px solid #6eb6de');
}).blur(function(){
  $(this).css('border','none');
});

function register_btn(){
  $('#register #field_error').html('');
  var username = $('#username').val();
  var email =$('#reg_email').val();
  var brand = $('#brand_name').val();
  var brand_cat = $('#brand_cat').val();
  var city = $('#city').val();
  var lcn = $('#licence').val();
  var address = $('#address').val();
  var pass = $('#password').val();
  var logo = $('#logo_file').val();
  var type = 'brand_register';

  var is_error = '';

  if(username==''){
    $('.username_err').html('Username is Required');
    is_error='yes';
  }
  if(email==''){
    $('.email_err').html('Email is Required');
    is_error='yes';
  }
  if(brand==''){
    $('.brand_err').html('Brand name is required');
    is_error='yes';
  }
  if(brand_cat==null){
    $('.cat_err').html('Category required');
    is_error='yes';
  }
  if(city==null){
    $('.city_err').html('#city_err').html('City is required.');
    is_error='yes';
  }
  if(lcn==''){
    $('.licence_err').html('Licence is required');
    is_error='yes';
  }
  if(address==''){
    $('.address_err').html('Address is required');
    is_error='yes';
  }
  if(pass==''){
    $('.pass_err').html('Password is required.');
    is_error='yes';
  }
  if(logo==''){
    $('.logo_err').html('file is required');
    is_error='yes';
  }
  if(is_error==''){
    $.ajax({
      url:'ajax-data.php',
      type:'post',
      data:{username:username,email:email,brand:brand,brand_cat:brand_cat,city:city,lcn:lcn,address:address,pass:pass,logo:logo,type:type},
      success:function(result){
        if(result=='username_ex'){
          $('.username_err').html('Username already exits.');
        }
        if(result=='email_ex'){
          $('.email_err').html('Email already exits.');
        }
        if(result=='shop_ex'){
          $('.brand_err').html('This brand already exits.');
        }
        if(result=='location_ex'){
          $('.address_err').html('This location already exits.');
        }
        if(result=='done'){
          location.href='http://localhost/ecom/brand/login.php?rt';
        }
      }
    });
  }

}

///--------- Login Section------////

function login_form(){
  $('#login #field_error').html('');
  var username = $('#login_username').val();
  var pass = $('#login_password').val();
  var type = "brand_login";
  var is_error='';
  if(username==''){
    $('.log_user_err').html('Username is Required.');
    is_error='yes';
  }
  if(pass==''){
    $('.log_pass_err').html('Password is required.');
    is_error='yes';
  }
  if(is_error==''){
    $.ajax({
      url:'ajax-data.php',
      type:'post',
      data:{username:username,pass:pass,type:type},
      success:function(result){
        if(result=='done'){
          location.href='index.php';
        }
        if(result=='deactive'){
          $('.log_pass_err').html('Your account has not active');
        }
        if(result=='failed'){
          $('.log_pass_err').html('Login info incorrect. Please try again.');
        }
      }
    });
  }
}

////-------logout------////

function logout_btn(){
  var type = "logout_brand";
  $.ajax({
    url:'ajax-data.php',
    type:'post',
    data:{type:type},
    success:function(result){
      if(result=='done'){
        location.href='login.php';
      }
    }
  });
}
function get_sub_cat(sub_cat_id){
  var cat_id = jQuery('#cat_id').val();
  var type="sub_cat";
  jQuery.ajax({
      url:'ajax-data.php',
      type:'post',
      data:{cat_id:cat_id,sub_cat_id:sub_cat_id,type:type},
      success:function(result){
          jQuery('#sub_cat_id').html(result);
      }
  });
}
/////---Brand status---////

function brand_sts(pid,sts){
  var type = "brand_status";
  $.ajax({
    url:'ajax-data.php',
    type:'post',
    data:{pid:pid,sts:sts,type:type},
    success:function(result){
      $('#table_body').html(result);
    }
  });
}

/////-----DELETE PRODUCT-------////

function dlt_btn(pid){
  var type = "delete_row";
  $.ajax({
    url:'ajax-data.php',
    type:'post',
    data:{pid:pid,type:type},
    success:function(result){
      $('#table_body').html(result);
    }
  });
}

////-----Show Rows---////
function show_rows(){
    var row =$('#show_rows').val();
    var type= "show_rows";
    if(row!=''){
      $.ajax({
        url:'ajax-data.php',
        type:'post',
        data:{row:row,type:type},
        success:function(result){
          $('#table_body').html(result);
        }
      });
    }
  }
////----search---///
$('#search_pdt').keyup(function(){
  var val=$('#search_pdt').val();
  var type="search_pdt";
    $.ajax({
        url:'ajax-data.php',
        type:'post',
        data:{val:val,type:type},
        success:function(result){
          $('#table_body').html(result);
        }
    });
});


// function edit_img(){
//   var fd = new FormData();
//   var files = $('#edit_img')[0].files;
//   alert(files);
//   // Check file selected or not
//   // if(files.length > 0 ){
//   //    fd.append('file',files[0]);

//   //    $.ajax({
//   //       url: 'upload_profile.php',
//   //       type: 'post',
//   //       data: fd,
//   //       contentType: false,
//   //       processData: false,
//   //       success: function(response){
//   //         if(response != 0){
//   //             $("#img").attr("src",response); 
//   //             $(".preview img").show(); // Display image element
//   //          }else{
//   //             alert('file not uploaded');
//   //          }
//   //       },
//   //    });
//   // }else{
//   //    alert("Please select a file.");
//   // }
// }

////----Order Delete---///

function order_dlt_btn(oid){
    var type="order_delete";
    $.ajax({
      url:'ajax-data.php',
      type:'post',
      data:{type:type,oid:oid},
      success:function(result){
        $('#table_body').html(result);
        
      }
    });
}
function brand_logo(){

    var fd = new FormData();
    var files = $('#logo_file')[0].files;
  if(files.length > 0 ){
     fd.append('file',files[0]);
     $.ajax({
        url: 'logo_add.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
        },
     });
  }
}