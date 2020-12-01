$(function(){
    var lphoneFlag = 0;
    var lpassFlag = 0;

    // login
    var loginstateFlag
    $("#login-phone").change(function(){
        if($(this).val()!=0){
            lphoneFlag = 1;
            $(this).removeClass("is-invalid")
        }else {
            lphoneFlag=0;
            $(this).addClass("is-invalid").removeClass("is-valid").siblings(".invalid-feedback").text("请填写手机号, 邮箱或用户名");
        }
    })

    $("#login-password").on({focus:function(){
        $(this).removeClass("is-invalid");
    },change:function(){
        if($(this).val==0){
            $(this).addClass("is-invalid").removeClass("is-valid").siblings(".invalid-feedback").text("请输入密码");
            lpassFlag = 0;
        }else{
            $(this).removeClass("is-invalid");
            lpassFlag = 1;
        }
    }
    })
    $("#login").click(function(){
        if($("#login_state").is(":checked")){
            loginstateFlag = 1
        }else loginstateFlag = 0
        if(lphoneFlag){
            $("#login-phone").addClass("is-valid").removeClass("is-invalid");
        }else{
            $("#login-phone").addClass("is-invalid").removeClass("is-valid").siblings(".invalid-feedback").text("请填写手机号, 邮箱或用户名");
            return false;
        }
        if(!lpassFlag){
            $("#login-password").addClass("is-invalid").removeClass("is-valid").siblings(".invalid-feedback").text("请输入密码");
            return false;
        }
        $.ajax({
            type: "POST",
            url: $(this).attr("data-purl"),
            data: {
                "login_i" : $("#login-phone").val(),
                "password" : $("#login-password").val(),
                "login_state" : loginstateFlag
            },
            success: data=>{
                if(data.error){
                    if(data.error.code=='003'){
                        $("#login-phone").addClass("is-invalid").siblings(".invalid-feedback").text("此用户不存在");
                    }else if(data.error.code=='006'){
                        $("#login-password").addClass("is-invalid").siblings(".invalid-feedback").text("账号或者密码错误");
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
                }else{
                    $("#modal").modal("hide");
                    $("#login-password").removeClass("is-invalid is-valid");
                    $("#login-phone").removeClass("is-valid is-invalid");
                    $("#login-reset").click();
                    $("body").append(`
                        <div class="alert alert-success alert-dismissible fade show fixed-top text-center" role="alert">
                            <strong>登录成功!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                    $('#login-btn').attr('onclick', "window.location.href='"+$("#login-btn").attr("data-url")+"'").removeAttr("data-toggle").html("<img style='width:38px;height:38px' src='"+data.success.avatar_url+"?s=38'>").addClass("p-0").removeClass("btn-block")
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
    $(".oauth-login").click(function(){
        var url = $(this).data("login-url")
        // window.screenLeft
        // window.open(url, _self)
        window.open(url, '_blank', "top=100, left=400, toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=800, height=600")
    })
})