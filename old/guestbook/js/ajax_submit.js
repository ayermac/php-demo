$(document).ready(function() {
    $("#validateBtn").click(function() {
        var nickname = $("#nickname").val();
        var content = $("#content").val();
        var email = $("#email").val();
        var data = {
            nickname : nickname,
            content : content,
            email : ''
        };
    
    $.post('./post.php', data, function(data, textStatus, xhr) {
        if (textStatus == 'success') {
            var data = $.parseJSON(data);
            if (data.error == '0') {
                alert(data.msg);
                window.location.href = '?page=1';//刷新页面，回到第一页。这样用户就能看到他的留言了
            } else {
                alert(data.msg);
            }
        }
    });

    });
});