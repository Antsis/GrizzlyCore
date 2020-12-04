$(function(){
    
    // password相关
    var password_old_password_flag = 0
    var password_new_password_flag = 0
    var password_confirm_password_flag = 0
    var $password_old_password = $('#password-old-password')
    var $password_new_password = $('#password-new-password')
    var $password_confirm_password = $('#password-confirm-password')

    $password_old_password.on('input', function(){
        if($(this).val()==''){
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请填写旧密码");
            password_old_password_flag = 0
        }else{
            $(this).removeClass('is-invalid')
            password_old_password_flag = 1
        }
    })

    $password_new_password.on('input', function(){
        if($(this).val()==''){
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请填写新密码");
            password_new_password_flag = 0
        }else{
            $(this).removeClass('is-invalid')
            password_new_password_flag = 1

        }
        
    })

    $password_confirm_password.on('input', function(){
        if($(this).val()==''){
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请填写确认密码");
            password_confirm_password_flag = 0
        }else{
            $(this).removeClass('is-invalid')
            password_confirm_password_flag = 1
        }
        if($password_new_password.val() != $(this).val()){
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("两次密码不正确");
            password_confirm_password_flag = 0
        }else{
            $(this).removeClass('is-invalid')
            password_confirm_password_flag = 1
        }
        
    })

    $('#password-save').click(function(){
        if(!password_old_password_flag){
            $password_old_password.removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请填写旧密码");
            return false
        }
        if(!password_new_password_flag){
            $password_new_password.removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请填写新密码");
            return false
        }
        if(!password_confirm_password_flag){
            $password_confirm_password.removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请填写确认密码");
            return false
        }
        $.ajax({
            url: $(this).data('url'),
            type: 'POST',
            data: {
                'old_p' : $password_old_password.val(),
                'new_p' : $password_new_password.val(),
                'confirm_p' : $password_confirm_password.val(),
            },
            success: data => {
                if(data.success){
                    $("body").append(`
                        <div class="alert alert-success alert-dismissible fade show fixed-top text-center" role="alert">
                            <strong>保存成功!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                }else if(error.code=='002'){
                    $password_old_password.removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("旧密码不正确");
                }else{
                    $("body").append(`
                        <div class="alert alert-danger alert-dismissible fade show fixed-top text-center" role="alert">
                            <strong>修改失败!</strong>请重试一遍
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                }

            },
            error: ()=>{
                $("body").append(`
                <div class="alert alert-danger alert-dismissible fade show fixed-top text-center" role="alert">
                    <strong>服务器错误!</strong>请联系管理员
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
              `);
            }
        })
        return false
    })

})