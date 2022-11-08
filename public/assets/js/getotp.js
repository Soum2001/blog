
$(document).ready(function(){
 
});
let digitValidate = function(ele){
    console.log(ele.value);
    ele.value = ele.value.replace(/[^0-9]/g,'');
    }
    let tabChange = function(val){
    let ele = document.querySelectorAll('input');
    if(ele[val-1].value != ''){
      ele[val].focus()
    }else if(ele[val-1].value == ''){
      ele[val-2].focus()
    }   
 }
function verify_otp(){
    $("#otp_dig1").val();
    $("#otp_dig2").val();
    $("#otp_dig3").val();
    $("#otp_dig4").val();
    $("#otp_dig5").val();
    $("#otp_dig6").val();
    var otp=$("#otp_dig1").val()+$("#otp_dig2").val()+$("#otp_dig3").val()+$("#otp_dig4").val()+
    $("#otp_dig5").val()+$("#otp_dig6").val();
   
   $.ajax({
    url:"verify_otp",
    type:"post",
    data:{otp:otp},
    success:function(respense){
      var res=JSON.parse(respense);
      if (res.status=='SUCCESS'){
        window.location="reset_password.php";
      }
    }
   });
}