$(function(){
    
    // access page
    // access add
    $('#access-name-add').change(function(){
        if($(this).val()==""){
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入权限名")
        }else{
            $(this).removeClass("is-invalid").addClass("is-valid").siblings(".invalid-feedback").text("")
        }
    })
    $('#access-urls-add').change(function(){
        $(this).removeClass("is-invalid").addClass("is-valid").siblings(".invalid-feedback").text("")
    })

    $('#access-add').click(function(){
        if($('#access-name-add').val()==""){
            $('#access-name-add').removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入权限名")
        }else{
            $('#access-name-add').removeClass("is-invalid").addClass("is-valid").siblings(".invalid-feedback").text("")
        }
        $.ajax({
            type: 'POST',
            url: $(this).data('url'),
            data:{
                'access-name' : $('#access-name-add').val(),
                'urls' : $('#access-urls-add').val()
            },
            success: data => {
                if(data.success){
                    $("#addAccessModal").modal("hide")
                    $("body").append(`
                        <div class="alert alert-success alert-dismissible fade show fixed-top text-center" role="alert">
                        <strong>添加成功!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload()"
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    `)
                    setTimeout(() => {
                        window.location.reload()
                    }, 1000);
                }else if(data.error.code == '002'){
                    $('#access-urls-add').removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入合法的Urls")
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
    })

    //access delete
    $(".access-delete").click(function(){
        if(!confirm("你确定要删除此账号吗")){
            return false
        }
        $.ajax({
            method: "DELETE",
            url: $(this).data('url'),
            data: {
                "access-id" : $(this).data('id')
            },
            success: data => {
                if(data.success){
                    $("body").append(`
                        <div class="alert alert-success alert-dismissible fade show fixed-top text-center" role="alert">
                        <strong>删除成功!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload()"
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    `)
                    setTimeout(() => {
                        window.location.reload()
                    }, 1000);
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
    })
    // access edit
    $('#editAccessModal').on('show.bs.modal', function(event){
        $(this).find('#access-id').text($(event.relatedTarget).data('id'))
        $(this).find('#access-name-edit').val($(event.relatedTarget).data('name'))
        $(this).find('#access-urls-edit').val($(event.relatedTarget).data('urls'))

    })

    $('#access-name-edit').change(function(){
        if($(this).val()==""){
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入权限名")
        }else{
            $(this).removeClass("is-invalid").addClass("is-valid").siblings(".invalid-feedback").text("")
        }
    })
    $('#access-urls-edit').change(function(){
        $(this).removeClass("is-invalid").addClass("is-valid").siblings(".invalid-feedback").text("")
    })
    $('#access-edit').click(function(){
        if($('#access-name-edit').val()==""){
            $('#access-name-edit').removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入权限名")
        }else{
            $('#access-name-edit').removeClass("is-invalid").addClass("is-valid").siblings(".invalid-feedback").text("")
        }
        $.ajax({
            type: 'PUT',
            url: $(this).data('url'),
            data:{
                'access-id' : $('#access-id').text(),
                'access-name' : $('#access-name-edit').val(),
                'urls' : $('#access-urls-edit').val()
            },
            success: data => {
                if(data.success){
                    $("#addAccessModal").modal("hide")
                    $("body").append(`
                        <div class="alert alert-success alert-dismissible fade show fixed-top text-center" role="alert">
                        <strong>修改成功!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.reload()"
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    `)
                    setTimeout(() => {
                        window.location.reload()
                    }, 1000);
                }else if(data.error.code == '002'){
                    $('#access-urls-add').removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入合法的Urls")
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
    })
})