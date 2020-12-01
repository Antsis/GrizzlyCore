$(function(){
    //avatar.html
    $("#close-btn").click(function(){
        window.location.href=$(this).data('url')+'?id='+Math.random()
    })
    $("#close-btn2").click(function(){
        window.location.href=$(this).data('url')+'?id='+Math.random()

    })
    var avatarFlag=0
    $("#avatar").change(function(){
        if($("#avatar").val()==null){
            avatarFlag=0
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请选择图片");
        }else{
            avatarFlag=1;
            $(this).removeClass("is-invalid").addClass("is-valid")
        }
    })
    $("#avatar-upload").click(function(){
        if(!avatarFlag){
            $("#avatar").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请选择图片");
            return false
        }
        var formData = new FormData()
        formData.append("image", $("#avatar")[0].files[0])
        $.ajax({
            type: "POST",
            url: $(this).attr("data-purl"),
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
        return false
    })
})