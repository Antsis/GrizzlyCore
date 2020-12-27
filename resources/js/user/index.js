$(function(){
    $.ajax({
        type: "POST",
        url: $("#login-btn-parent").data("url"),
        success: data => {
            if (data.success) {
                $("#login-btn").attr(
                    "onclick",
                    "window.location.href='" +
                        $("#login-btn").attr("data-url") + "'"
                )
                .removeAttr("data-toggle")
                .html(
                    "<img style='width:38px;height:38px' src='" +
                        data.success.avatar_url +
                        "?s=38'>"
                )
                .addClass("p-0")
                .removeClass("btn-block");
            }
        }
    });
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