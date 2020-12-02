$(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        type: "POST",
        url: $("#login-btn-parent").data("url"),
        success: data => {
            if (data.success) {
                $("#login-btn")
                    .attr(
                        "onclick",
                        "window.location.href='" +
                            $("#login-btn").attr("data-url") +
                            "'"
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

    
});
