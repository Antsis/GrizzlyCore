$(document).ready(function(){
    // 手机号正则表达式 /^1[3-9]\d{9}$/
    // 邮箱正则表达式 /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/
    // 密码强度正则表达式  

    //reg
    var phone_emailFlag = 0;
    var codeFlag = 0;
    
    var passwdFlag =0;
    var lphoneFlag = 0;
    var lpassFlag = 0;

    $("#reg-phone-email").change(function(){
        if(/^1[3-9]\d{9}$/.test($(this).val())||/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/.test($(this).val())){
            $(this).removeClass("is-invalid").addClass("is-valid");
            phone_emailFlag = 1;
        }else {
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入正确的手机号码或邮箱");
            phone_emailFlag = 0;
        }
    })

    //验证码动态检测
    $("#code").change(function(){
        $.ajax({
            type: "POST",
            url: $(this).attr("data-purl"),
            data: {
                "code" : $("#code").val(),
            },
            success: data => {
                if(data.success){
                    $("#code").removeClass("is-invalid").addClass("is-valid");
                    codeFlag = 1;
                }else {
                    $("#code").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入正确的验证码");
                    codeFlag = 0;
                }
            },
            error: () => {
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
    })

    //注册协议
    $("#reg-license").click(()=>{
        if($("#reg-license").is(":checked")){
            $("#reg-license").removeClass("is-invalid").addClass("is-valid");
        }else{
            $("#reg-license").removeClass("is-valid").addClass("is-invalid");
        }
    })

    //注册按钮检测
    $("#reg-submit").click(function(){
        if(phone_emailFlag){
            $("#reg-phone-email").removeClass("is-invalid").addClass("is-valid");
        }else{
            $("#reg-phone-email").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请填写手机号或邮箱");
            return false;
        }
        if(codeFlag){
            $("#code").removeClass("is-invalid").addClass("is-valid");
        }else{
            if($("#code").val()==0){
                $("#code").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入验证码");
            }
            return false;
        }
        if($("#reg-license").is(":checked")){
            $("#reg-license").removeClass("is-invalid").addClass("is-valid");
        }else{
            $("#reg-license").removeClass("is-valid").addClass("is-invalid");
            return false;
        }
        $.ajax({
            type: "POST",
            url: $(this).attr("data-purl"),
            async: false,
            data: {
                "phone_email" : $("#reg-phone-email").val(),
                "code" : $("#code").val()
            },
            success: data=> {
                if(data.error){
                    if(data.error.code=='004'){
                        $("#code").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("验证码错误");
                    }else if(data.error.code=='007'){
                        $("#reg-phone-email").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入正确的手机号码");
                    }else if(data.error.code=='009'){
                        $("#reg-phone-email").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入正确的邮箱");
                    }else if(data.error.code=='005'){
                        $("#reg-phone-email").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("此用户已经存在");
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
                    $("#feedback-phone-email").text(data.success.text);
                    time($("#resend"));
                    $("#reg-reset").click()
                    $("#code").removeClass("is-invalid is-valid");
                    $("#reg-phone-email").removeClass("is-invalid is-valid");
                    $("#reg-license").removeClass("is-invalid is-valid");
                    $("#modal").modal("hide");
                    $("#staticBackdrop").modal("show");
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
                  $("#reg-reset").click()
            }
        })

        $("#code-img").click();
        // $("#code").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请修改验证码");
        return false;
    })

    $("#refresh").on({click:function(){
        $("#code-img").attr("src", $("#code-img").data("src")+"?id="+Math.random());
        $("#code").removeClass("is-invalid");
    },mouseover:function(){
        $(this).children().css({
            transform: "rotate(360deg)",
            transition: "all 500ms linear"
        })
    },mouseout:function(){
        $(this).children().css({
            transform: "rotate(0)",
            transition: "all 500ms linear"
        })
    }
    }).css("cursor","pointer")

    // reg2
    
    $("#resend").click(function(){
        time($(this));
        $.ajax({
            type: "POST",
            url: $(this).attr("data-purl"),
            error: ()=>{
                $(".close").click()
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
    })

    $("#reg-password").change(function(){
        var $p = $(this).val();
        if(($p.length>7&&$p.length<21)&&((/\d/.test($p)&&/[a-zA-Z]/.test($p))||(/[a-zA-Z]/.test($p)&&/\W/.test($p))||(/\d/.test($p)&&/\W/.test($p)))){
            $(this).removeClass("is-invalid").addClass("is-valid");
            passwdFlag = 1;
        }else{
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("密码强度不符合要求, 请输入8-20位字母/数字/符号,至少包含两种的密码");
            passwdFlag = 0;
        }
    })

    $("#reg-submit2").click(function(){
        if(passwdFlag){
            $("#reg-password").removeClass("is-invalid").addClass("is-valid");
        }else{
            $("#reg-password").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入用于注册的密码");
            return false;
        }
        $.ajax({
            type: "POST",
            url: $(this).attr("data-purl"),
            data: {
                "code": $("#sms-code").val(),
                "password": $("#reg-password").val()
            },success: data=>{
                if(data=="error"){
                    $("body").append(`
                    <div class="alert alert-danger alert-dismissible fade show fixed-top text-center" role="alert">
                        <strong>服务器错误!</strong>请联系管理员
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                  `)
                  $("#reg-reset").click()
                }else if(data=="error2"){
                    $("#reg-password").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("密码强度不符合要求, 请输入8-20位字母/数字/符号,至少包含两种的密码");
                }else if(data=="error1"){
                    $("#sms-code").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("验证码错误");
                }else{
                    $("body").append(`
                        <div class="alert alert-success alert-dismissible fade show fixed-top text-center" role="alert">
                            <strong>成功注册!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                    $("#reg2-reset").click()
                    $("#reg-password").removeClass("is-invalid is-valid");
                    $('#login-btn').attr('onclick', "window.location.href='"+$("#login-btn").attr("data-url")+"'").removeAttr("data-toggle").html("<img style='max-width:38px;height:auto' src='"+data.success.avatar_url+"_38_38.jpg'>").addClass("p-0").removeClass("btn-block")
                }
            },error: ()=>{
                $("body").append(`
                    <div class="alert alert-danger alert-dismissible fade show fixed-top text-center" role="alert">
                        <strong>服务器错误!</strong>请联系管理员
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                  `);
                  $("#reg-reset2").click()

            }
        })
    })
    
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
                    $('#login-btn').attr('onclick', "window.location.href='"+$("#login-btn").attr("data-url")+"'").removeAttr("data-toggle").html("<img style='max-width:38px;height:auto' src='"+data.success.avatar_url+"_38_38.jpg'>").addClass("p-0").removeClass("btn-block")
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

var waitTime=60;
function time(ele) {
    if (waitTime == 0) {
        ele.removeAttr("disabled");
        ele.text("重新发送验证码");
        waitTime = 60;
    } else {
        ele.attr("disabled", "disabled")
        ele.text("重新发送验证码("+waitTime+"s)");
        waitTime--;
        setTimeout(function() {
            time(ele)
        }, 1000)
    }
}