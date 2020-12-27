$(function(){
    var nameFlag=1;
    var signatureFlag=1;
    $("#name").change(function(){
        if($(this).val().length<16){
            $(this).removeClass("is-invalid")
            nameFlag = 1;
        }else{
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("长度过长, 小于16位字符");
            nameFlag = 0;
        }
    })
    $("#signature").change(function(){
        if($(this).val().length<128){
            signatureFlag = 1;
            $(this).removeClass("is-invalid")
        }else{
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("长度过长, 小于128位字符");
            signatureFlag = 0;
        }
    })
    $("#profile-save").click(function(){
        if(!signatureFlag){
            $("#signature").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("长度过长, 小于128位字符");
            return false;
        }
        if(!nameFlag){
            $("#name").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("长度过长, 小于16位字符");
            return false;
        }
        $.ajax({
            type: "PUT",
            url: $(this).attr("data-purl"),
            data: {
                "name" : $("#name").val(),
                "gender" : $("#gender").val(),
                "birthday" : $("#birthday").val(),
                "signature" : $("#signature").val()
            },
            success: data=>{
                if(data.success){
                    $("body").append(`
                        <div class="alert alert-success alert-dismissible fade show fixed-top text-center" role="alert">
                            <strong>保存成功!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                // }else if(data=="success2"){
                //     $("body").append(`
                //         <div class="alert alert-success alert-dismissible fade show fixed-top text-center" role="alert">
                //             <strong>你并没有改变什么!</strong>
                //             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                //             <span aria-hidden="true">&times;</span>
                //             </button>
                //         </div>
                //     `);
                }else{
                    $("body").append(`
                        <div class="alert alert-danger alert-dismissible fade show fixed-top text-center" role="alert">
                            <strong>保存失败!</strong>请重试一遍
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
        return false;
    })


    //profile-contact
    var qqFlag=1;
    $("#qq").change(function(){
        if($(this).val()==""){
            qqFlag=1;
            $(this).removeClass("is-invalid")
        }else{
            if(/^[1-9][0-9]{4,11}$/.test($(this).val())){
                qqFlag=1;
                $(this).removeClass("is-invalid")
            }else{
                qqFlag=0;
                $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("QQ号格式不正确");
            }
        }
    })
    $("#profile-c-save").click(function(){
        if(!qqFlag){
            $("#qq").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("QQ号格式不正确");
            return false;
        }
        $.ajax({
            type: "PUT",
            url: $(this).attr("data-purl"),
            data: {
                'qq' : $("#qq").val()
            },
            success: data=>{
                if(data.success){
                    $("body").append(`
                        <div class="alert alert-success alert-dismissible fade show fixed-top text-center" role="alert">
                            <strong>保存成功!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                // }else if(data=="success2"){
                //     $("body").append(`
                //         <div class="alert alert-success alert-dismissible fade show fixed-top text-center" role="alert">
                //             <strong>你并没有改变什么!</strong>
                //             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                //             <span aria-hidden="true">&times;</span>
                //             </button>
                //         </div>
                //     `);
                }else{
                    $("body").append(`
                        <div class="alert alert-danger alert-dismissible fade show fixed-top text-center" role="alert">
                            <strong>保存失败!</strong>请重试一遍
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
        return false;
    })
})
$(function(){
    //avatar.html
    $(".close-btn").click(function(){
        window.location.href=$(this).data('url')+'?id='+Math.random()
    })
    $("#close-btn2").click(function(){
        window.location.href=$(this).data('url')+'?id='+Math.random()

    })

    $image = $('#image')

    var avatarFlag=0
    $("#avatar").change(function(){
        if($("#avatar").val()==null){
            avatarFlag=0
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请选择图片");
        }else{
            avatarFlag=1;
            $(this).removeClass("is-invalid").addClass("is-valid")
            $('#avatarEdit').modal('show')
        }
        var reader = new FileReader()
        reader.addEventListener('load', function() {
            $image.prop('src', reader.result)
            $image.cropper('destroy')
            $image.cropper({
                viewMode: 1,
                aspectRatio: 1 / 1,
                initialAspectRatio: 1 / 1,
            })
        }, false);
        $('#crop-btn').removeClass('invisible')
        reader.readAsDataURL(this.files[0])
    })


    $("#avatar-upload").click(function(){
        if(!avatarFlag){
            $("#avatar").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请选择图片");
            return false
        }
        $image.data('cropper').getCroppedCanvas().toBlob((blob) => {
            const formData = new FormData()
            formData.append('image', blob)
            $.ajax({
                type: "POST",
                url: $('#avatar-upload').data("purl"),
                data: formData,
                processData : false,
                contentType : false,
                success: data=>{
                    if(data.success){
                        $("#staticBackdrop").modal('show')
                    }else if(data.error.code=='003'){
                        $("body").append(`
                            <div class="alert alert-danger alert-dismissible fade show fixed-top text-center" role="alert">
                                <strong>上传失败!</strong>格式类型错误, 只允许jpg/png格式
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `);
                    }else if(data.error.code){
                        $("body").append(`
                            <div class="alert alert-danger alert-dismissible fade show fixed-top text-center" role="alert">
                                <strong>上传失败!</strong>文件太大
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `);
                    }else{
                        $("body").append(`
                            <div class="alert alert-danger alert-dismissible fade show fixed-top text-center" role="alert">
                                <strong>服务器错误!</strong>请联系管理员
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
        }, 'image/jpeg')
        return false
    })

    $('#rotate').click(function(){
        $image.cropper("rotate", 90)
    })
    $('#zoom-out').click(function(){
        $image.cropper('zoom', -0.1)
    })
    $('#zoom-in').click(function(){
        $image.cropper('zoom', 0.1)
    })
})

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
        $p = $(this).val()
        if(($p.length>7&&$p.length<21)&&((/\d/.test($p)&&/[a-zA-Z]/.test($p))||(/[a-zA-Z]/.test($p)&&/\W/.test($p))||(/\d/.test($p)&&/\W/.test($p)))){
            $(this).removeClass("is-invalid").addClass("is-valid");
            password_new_password_flag = 1;
        }else{
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("密码强度不符合要求, 请输入8-20位字母/数字/符号,至少包含两种的密码");
            password_new_password_flag = 0;
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
            $(this).removeClass('is-invalid').addClass("is-valid");
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
            type: 'PUT',
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

    // 修改邮箱
    var email_old_password_flag = 0
    var email_new_email_flag = 0
    var email_confirm_code_flag = 0
    var $email_old_password = $('#email-old-password')
    var $email_new_email = $('#email-new-email')
    var $email_confirm_code = $('#email-confirm-code')

    $email_old_password.on('input', function(){
        if($(this).val()==''){
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请填写旧密码");
            email_old_password_flag = 0
        }else{
            $(this).removeClass('is-invalid')
            email_old_password_flag = 1
        }
    })

    $email_new_email.on('input', function(){
        if($(this).val==''){
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请填写新邮箱");
            email_new_email_flag = 0
        }else{
            $(this).removeClass('is-invalid')
            email_new_email_flag = 1
        }
        if(/^1[3-9]\d{9}$/.test($(this).val())||/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/.test($(this).val())){
            $(this).removeClass("is-invalid").addClass("is-valid");
            email_new_email_flag = 1;
        }else {
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入正确的邮箱格式");
            email_new_email_flag = 0;
        }
    })

    $email_confirm_code.on('input', function(){
        if($(this).val==''){
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请填写新邮箱");
            email_confirm_code_flag = 0
        }else{
            $(this).removeClass('is-invalid')
            email_confirm_code_flag = 1 
        }
        if($(this).val().length!=6){
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请填写正确的验证码");
            email_confirm_code_flag = 0
        }else{
            $(this).removeClass('is-invalid')
            email_confirm_code_flag = 1
        }
    })

    $('#email_send_email_code_btn').click(function(){
        if(!email_old_password_flag){
            $email_old_password.removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请填写旧密码");
            return false
        }
        if(!email_new_email_flag){
            $email_new_email.removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请填写新邮箱");
            return false
        }
        $.ajax({
            type: 'POST',
            url: $(this).data('url'),
            data: {
                'email' : $email_new_email.val(),
                'password' : $email_old_password.val(),
            },
            success: data => {
                if(data.success){
                    sendEmailCode($(this))
                }else if(data.success.code=='004'){
                    $email_old_password.removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("旧密码错误");
                }else{
                    $("body").append(`
                        <div class="alert alert-danger alert-dismissible fade show fixed-top text-center" role="alert">
                            <strong>邮件发送失败!</strong>请重试一遍
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

    $('#email-save').click(function(){
        if(!email_old_password_flag){
            $email_old_password.removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请填写新邮箱");
            return false
        }

        if(!email_new_email_flag){
            $email_new_email.removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请填写新邮箱");
            return false
        }
        if(!email_confirm_code_flag){
            $email_confirm_code.removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请填写新邮箱");
            return false
        }
        $.ajax({
            type: 'PUT',
            url: $(this).data('url'),
            data: {
                'code' : $email_confirm_code.val(),
                'email' : $email_new_email.val(),
                'password' : $email_old_password.val(),
            },
            success: data =>{
                if(data.success){

                }else{
                    $("body").append(`
                        <div class="alert alert-danger alert-dismissible fade show fixed-top text-center" role="alert">
                            <strong>邮件发送失败!</strong>请重试一遍
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


function sendEmailCode(e, time=60){
    if (time == 0) {
        e.removeAttr("disabled");
        e.text("重新发送验证码");
        time = 60;
    } else {
        e.attr("disabled", "disabled")
        e.text("重新发送验证码("+time+"s)");
        time--;
        setTimeout(function() {
            sendEmailCode(e, time)
        }, 1000)
    }
}