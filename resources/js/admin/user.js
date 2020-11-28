$(function(){
    // user page 
    // user delete
    $(".user-delete").click(function(){
        if(!confirm("你确定要删除此账号吗")){
            return false
        }
        $.ajax({
            method: "DELETE",
            url: $(this).data('url'),
            data: {
                "user-id" : $(this).data('id')
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

    //user edit
    $("#editUserModal").on('show.bs.modal', function(event){
        $(this).find('#user-name-edit').val($(event.relatedTarget).data('name'))
        $(this).find('#user-email-edit').val($(event.relatedTarget).data('email'))
        $(this).find('#user-id').text($(event.relatedTarget).data('id'))
    })
    $("#user-name-edit").change(function(){
        if($(this).val()==""){
            $(this).removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入用户名")
            return false
        }else{
            $(this).removeClass("is-invalid").addClass("is-valid").siblings(".invalid-feedback").text("")
        }
    })
    $("#user-edit").on("click", function(){
        if($("#user-name-edit").val()==""){
            $("#user-name-edit").removeClass("is-valid").addClass("is-invalid").siblings(".invalid-feedback").text("请输入用户名")
            return false
        }else{
            $("#role-name-edit").removeClass("is-invalid").addClass("is-valid").siblings(".invalid-feedback").text("")
        }
        $.ajax({
            type: "PUT",
            url: $(this).data("url"),
            data: {
                "user-id" : $('#user-id').text(),
                "user-name" : $('#user-name-edit').val(),
                "user-email" : $('#user-email-edit').val()
            },
            success: data => {
                if(data.success){
                    $("#editUserModal").modal("hide")
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

    // User role select
    $(".get-user-id").click(function(){
        $($('#role-select').children()).each(function(){
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
                
                $($('#role-select').children()).each(function(){
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

    $("#editUserRoleModal").on('show.bs.modal', function(event){
        $(this).find('#user-id-2').text($(event.relatedTarget).data('id'))
    })
    $("#user-role-edit").click(function(){
        $.ajax({
            type: "POST",
            url: $(this).data("url"),
            data: {
                "user-id" : $('#user-id-2').text(),
                "user-roles" : $('#role-select').val(),
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