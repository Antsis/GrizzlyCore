$(function(){
    // 侧边导航栏 按钮跳转
    $(".admin-btn-a").on("click", function(){
        window.location.href = $(this).data("url")
    })

})