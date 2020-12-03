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
