/**
 * Created by Administrator on 2016/5/28.
 */
$(function(){
    $("#btnLogin").click(function(){
        var $txtName=$("#txtName");
        var $txtPwd=$("#txtPwd");
        if ($txtName.val()!= "" && $txtPwd.val().replace(" ", "") != "") {
            Login($txtName.val(), $txtPwd.val());
        }
        else {
            if ($txtName.val().replace(" ", "") == "") {
                alert("用户名不能为空!");
                $txtName.focus();
                return false;
            }
            else {
                alert("密码不能为空!");
                $txtPwd.focus();
                return false;
            }
        }

    });

    $("#btnCancel").click(function () {
        $("#txtName").val("");
        $("#txtPwd").val("");
    });

});

function Login(name,pwd){
    $("#login-msg").ajaxStart(function () {
        $(this).show().html("正在发送登录请求...");
    });
    $("#login-msg").ajaxStop(function () {
        $(this).html("请求处理已完成。").hide();
    });

    $.ajax({
        type:"GET",
        url:"index.php",
        data:"action=login&name="+name+"&password="+pwd,
        success:function(data){
            console.log(data);
            if(data=="success"){
                window.location.href="ChatMain.html";
            }else{
                alert("用户名和密码不正确!");
                return false;
            }
        }
    });


}