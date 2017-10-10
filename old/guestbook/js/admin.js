$(document).ready(function() {
	$('.option').click(function() {
		var id = $(this).parent().siblings('.id').text();
		var option = $(this).val();
		$.post('../admin/lock.php', {id: id,option:option}, function(data, textStatus, xhr) {
			if (textStatus == 'success') {
				var data = $.parseJSON(data);
				if (data.error == '0') {
					alert(data.msg);
					window.location.reload()
				} else {
					alert(data.msg);
				}
			}
		});
	});
	var id = 0;
	$('.reply').click(function() {
		id = $(this).parent().siblings('.id').text();
		$("#replyid").val(id);
	});
	$('#sub').click(function() {
		var content = $('#replycontent').val();
		$.post('../admin/reply.php', {reply: content,id:id}, function(data, textStatus, xhr) {
			if (textStatus == 'success') {
				var data = $.parseJSON(data);
				alert(data.msg);
				window.location.reload();
			}
		});
	});
});