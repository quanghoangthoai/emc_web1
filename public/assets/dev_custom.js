var ajax_process = false;
function ajax_login(form, is_popup = false) {
    if (!ajax_process) {
        ajax_process = true;
        var url_ajax = $(form).data("action");
        $.ajax({
            type: "post",
            url: url_ajax,
            data: $(form).serialize(),
            dataType: "JSON",
            success: function(res) {
                ajax_process = false;
                if (res.status) {
                    $("#resultLoginMessage")
                        .removeClass("text-danger")
                        .addClass("text-success")
                        .text(res.message)
                        .slideDown(100);

                    setTimeout(() => {
                        $("#resultLoginMessage").slideUp(100);
                        if (is_popup) window.location.reload();
                        else window.location.href = res.redirect_to;
                    }, 1500);
                } else {
                    $("#resultLoginMessage")
                        .removeClass("text-success")
                        .addClass("text-danger")
                        .text(res.message)
                        .slideDown(100);

                    setTimeout(() => {
                        $("#resultLoginMessage").slideUp(100);
                    }, 3500);
                }
            }
        });
    }
}

function login_social(url, is_popup = false) {
    var popupWidth = 640,
        popupHeight = 640,
        xPosition = $(window).width() / 2 - popupWidth / 2 + window.screenX,
        yPosition = $(window).height() / 2 - popupHeight / 2,
        textSize =
            "location=yes, scrollbars=yes, status=yes width=" +
            popupWidth +
            ", height=" +
            popupHeight +
            ", left=" +
            xPosition +
            ", top=" +
            yPosition;

    window.open(url, window.location, textSize);
}

function callback_login_social(res) {
    res = JSON.parse(res);
    if (res.status) {
        window.location.reload();
    } else {
        alert(res.message);
    }
}
