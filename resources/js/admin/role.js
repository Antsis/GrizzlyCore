$(function(){
    // 角色页面
    // role add
    $("#role-name-add").change(function(){
        if($(this).val()==""){
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入角色名")
            return false
        }else{
            $(this).removeClass("is-invalid").addClass("is-valid").siblings(".invalid-feedback").text("")
        }
    })
    
    $("#role-add").on("click", function(){
        alert(1)
        if($("#role-name-add").val()==""){
            $("#role-name-add").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入角色名")
            return false
        }else{
            $("#role-name-add").removeClass("is-invalid").addClass("is-valid").siblings(".invalid-feedback").text("")
        }
        $.ajax({
            type: "POST",
            url: $(this).data("url"),
            data: {
                "role-name" : $('#role-name-add').val()
            },
            success: data => {
                if(data.success){
                    $("#addRoleModal").modal("hide")
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

    // role edit
    $("#editRoleModal").on('show.bs.modal', function(event){
        $(this).find('#role-name-edit').val($(event.relatedTarget).data('name'))
        $(this).find('#role-id').text($(event.relatedTarget).data('id'))
    })

    $("#role-name-edit").change(function(){
        if($(this).val()==""){
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入角色名")
            return false
        }else{
            $(this).removeClass("is-invalid").addClass("is-valid").siblings(".invalid-feedback").text("")
        }
    })

    $("#role-edit").on("click", function(){
        if($("#role-name-edit").val()==""){
            $("#role-name-edit").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入角色名")
            return false
        }else{
            $("#role-name-edit").removeClass("is-invalid").addClass("is-valid").siblings(".invalid-feedback").text("")
        }
        $.ajax({
            type: "PUT",
            url: $(this).data("url"),
            data: {
                "role-id" : $('#role-id').text(),
                "role-name" : $('#role-name-edit').val()
            },
            success: data => {
                if(data.success){
                    $("#editRoleModal").modal("hide")
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

    // delete role button
    $(".role-delete").click(function(){
        if(!confirm('你确定要删除此账号吗')){
            return false
        }
        $.ajax({
            method: "DELETE",
            url: $(this).data('url'),
            data: {
                "role-id" : $(this).data('id')
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

    // role page access select
    $(".get-role-id").click(function(){
        $($('#access-select').children()).each(function(){
            $(this).attr('selected', false)
        })
        $.ajax({
            type: 'GET',
            url: $(this).data('url'),
            data: {
                "id" : $(this).data('id'),
            },
            success: data =>{
                // $('#role-select').children(":first").attr('selected', false)
                
                $($('#access-select').children()).each(function(){
                    data.forEach(element => {
                        if($(this).val()==element){
                            $(this).attr('selected', true)
                        }
                    });
                })
            },
            error: ()=>{

            }
        })
    })

    $("#editRoleAccessModal").on('show.bs.modal', function(event){
        $(this).find('#role-id-2').text($(event.relatedTarget).data('id'))
    })
    $("#role-access-edit").click(function(){
        $.ajax({
            type: "PATCH",
            url: $(this).data("url"),
            data: {
                "role-id" : $('#role-id-2').text(),
                "role-access" : $('#access-select').val(),
            },
            success: data => {
                if(data.success){
                    $("#editUserRoleModal").modal("hide")
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
                }else if(data.notify){
                    $(".toast").toast('show')
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
