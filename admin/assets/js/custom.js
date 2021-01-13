
function get_sub_cat(sub_cat_id){
    var cat_id = jQuery('#cat_id').val();
    jQuery.ajax({
        url:'get_sub_cat.php',
        type:'post',
        data:{cat_id:cat_id,sub_cat_id:sub_cat_id},
        success:function(result){
            jQuery('#sub_cat_id').html(result);
        }
    });
}

function delete_product(pid){
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
                url:'delete_product.php',
                type:'post',
                data:{pdt_id:pid},
                success:function(result){
                    swal("Poof! File has been deleted!", {
                        icon: "success",
                      });
                      jQuery('.delete').parents('tr').last().hide();
                   // location.reload();   
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


//  $('table').on("click"," tr #dlt_dt", function(){
//      alert("ok");
//       var dlt_id = $(this).data("id");
//       alert(dlt_id);
//  });

 function delete_btn(r,did){
  var i = r.parentNode.parentNode.rowIndex;
  var type='delete_user';
  
  jQuery.ajax({
    url:'ajax-data.php',
    type:'post',
    data:{id:did,type:type},
    success:function(result){
        if(result == 'done'){
          document.getElementById("myTable").deleteRow(i);
        }
        if(result == 'failed'){
          alert('Something Went wrong');
        }
    }
  });
 }

 function slide_btn(pid){
    var term = "slide_product";
    jQuery.ajax({
      url:'ajax-data.php',
      type:'post',
      data:{type:term,pid:pid},
      success:function(result){
        location.reload();
      }
    });
 }