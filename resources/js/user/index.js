$(function(){
    
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