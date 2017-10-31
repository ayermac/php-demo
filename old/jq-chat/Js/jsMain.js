/**
 * Created by Administrator on 2016/5/28.
 */
$(function(){
    $.ajax({
        type:"GET",
        url:"index.php",
        action:"action=checkLoginState",
        success:function(data){
            if(data!="true"){
                window.location.href="Login.html";
            }
        }

    });

});