$(document).ready(function() {
    $('#defaultForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
	
            nickname: {
                message: '姓名无效',
                validators: {
                    notEmpty: {
                        message: '姓名不能为空'
                    },
                 stringLength: {
                        min: 1,
                        max: 10,
                        message: '姓名必须小于10个字'
                    }
                }
            },
            content: {
                validators: {
                    notEmpty: {
                        message: '内容不能为空'
                    },
                 stringLength: {
                        min: 1,
                        max: 50,
                        message: '内容必须小于50个字'
                    }
                }
            },
            email: {
                validators: {
                    emailAddress: {
                        message: '输入不是有效的电子邮件地址'
                    }
                }
            },
          
           
        }
    });

    // Validate the form manually
    $('#validateBtn').click(function() {
        $('#defaultForm').bootstrapValidator('validate');
    });

    $('#resetBtn').click(function() {
        $('#defaultForm').data('bootstrapValidator').resetForm(true);
    });


});