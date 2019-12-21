//Register js
jQuery(document).on('submit','.submit_register_form_rohit',function(){
    
    var get_site_url      = jQuery('.get_site_url').val();
    var reg_billing_phone = jQuery('.reg_billing_phone').val();
    var submit_status     = jQuery('.submit_status').val();
    
    if(reg_billing_phone !=="" ){
        
            var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
        
            if (filter.test(reg_billing_phone) && reg_billing_phone.length==10) {
                 if(submit_status==1){ 
                   jQuery.ajax({
                        url:get_site_url+'/otp.php',
                        dataType:'json',
                        method:'POST',
                        data:{phone_number:reg_billing_phone},
                        beforeSend:function(){
                            jQuery('.apply_online_submit').html('....  OTP Sending ....');
                        },
                        success:function(da){ 
                            
                            jQuery('.apply_online_submit').html('Submit'); 
                            
                            if(da.error==1){ 
                                alert('OTP Send Successfully on Your Mobile Number');
                                jQuery('.get_otp').val(da.otp);
                                jQuery('.all_log_bg').show();
                                jQuery('.apply_online_submit').html('Submit').hide();
                                  
                                
                            }
                            return false;  
                            
                            
                            
                            } 
                         });    
                   return false; 
                }else{
                    return true;
                }
                    
            }else{
                jQuery('.reg_billing_phone').focus();
                alert('Invalid Mobile Number');
                return false;        
            } 
    
    }
    return false
   
});

   
    //verify otp number
    jQuery(document).on('click','.submit_otp',function(){
          var fill_otp = jQuery('.fill_otp').val();  
          var get_otp  = jQuery('.get_otp').val();
          
          if(fill_otp !==""){
               
              if(get_otp==fill_otp){ 
                  jQuery('.submit_status').val(2);
                  jQuery('.all_log_bg').hide('slow');
                  jQuery('.apply_online_submit').show();
                  alert('Mobile Number Verify Successfully');
                  //jQuery('.submit_register_form_rohit').submit();  
              }else{
                jQuery('.fill_otp').addClass('error_border').focus();
                alert('Invalid OTP Number');    
              }
              
          }else{
              
              jQuery('.fill_otp').addClass('error_border').focus();
              alert('Please Enter OTP');
          }
    }); 

 //resend otp
    jQuery(document).on('click','.resend_otp',function(){
        var get_site_url      = jQuery('.get_site_url').val();
        var phone_number    = jQuery('.reg_billing_phone').val();
        if(phone_number !== ""){
            var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
            if (filter.test(phone_number)) {
                    jQuery.ajax({
                        url:get_site_url+'/otp.php', 
                        method:'POST',
                        data:{re_phone_number:phone_number},
                        beforeSend:function(){
                            jQuery('.resend_otp').html('Sending ....');
                        },
                        success:function(da){
                            
                            jQuery('.resend_otp').html('ReSend OTP');
                            alert('OTP Send Successfully on Your Mobile Number');
                             jQuery('.get_otp').val(da);
                            
                            } 
                         }); 
            }
        }
    });
 
