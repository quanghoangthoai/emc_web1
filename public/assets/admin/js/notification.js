var timer = 0;
var timer_is_on = 0;
var load_notification = 1;

function notifyMe(txt_notification) {
    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
        alert("This browser does not support system notifications");
        // This is not how you would really do things if they aren't supported. :)
    }

    // Let's check whether notification permissions have already been granted
    else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
        var notification = new Notification(txt_notification);
    }

    // Otherwise, we need to ask the user for permission
    else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function (permission) {
            // If the user accepts, let's create a notification
            if (permission === "granted") {
                var notification = new Notification(txt_notification);
            }
        });
    }

    // Finally, if the user has denied notifications and you
    // want to be respectful there is no need to bother them any more.
}

function cms_get_notification() {
    if (!timer_is_on) {
        clearTimeout(timer);
        timer_is_on = 0;
        if (load_notification) {
            load_notification = 0;
            $.ajax({
                type: "post",
                url: notification_url_load,
                data: {
                    _token: _token
                },
                dataType: "JSON",
                success: function (data) {
                    load_notification = 1;
                    $("#notification_load").html(data.html_notification);
                    if (data.num_new_notify > 0) {
                        $("#num_notification")
                            .show()
                            .html(data.num_new_notify);
                        app.showNotify("Có thông báo mới", "success");
                        if (!document.hasFocus()) {
                            notifyMe("Có thông báo mới");
                        }
                    } else {
                        $("#num_notification").hide();
                    }
                    // call the function again
                    // timer = setTimeout(function() {
                    //     cms_get_notification();
                    // }, 30000); // 30s
                }
            });
        }
    }
}

function notify_mark_read_all() {
    if (load_notification) {
        load_notification = 0;
        $.ajax({
            type: "post",
            url: notification_url_load,
            data: {
                _token: _token,
                action: "mark_read_all"
            },
            dataType: "JSON",
            success: function (data) {
                load_notification = 1;
                $("#notification_load")
                    .find("li.new")
                    .each(function (i, el) {
                        $(el).removeClass("new");
                        $(el).attr("href", $(el).data("href"));
                        $(el).removeAttr("onclick");
                    });
                $("#num_notification").hide();
            }
        });
    }
}

function go_notify_item(el) {
    if (load_notification) {
        load_notification = 0;
        $.ajax({
            type: "post",
            url: notification_url_load,
            data: {
                _token: _token,
                action: "check_not_new",
                id: $(el).data("id")
            },
            dataType: "JSON",
            success: function (data) {
                load_notification = 1;

                if ($(el).data("href") != "") {
                    window.location.href = $(el).data("href");
                } else {
                    if (data.num_new_notify > 0) {
                        $("#num_notification")
                            .show()
                            .html(data.num_new_notify);
                    } else {
                        $("#num_notification").hide();
                    }
                    cms_get_notification();
                }

                return false;
            }
        });
    }
}

$(function () {
    $("#notification_load").click(function (e) {
        e.stopPropagation();
    });
    cms_get_notification();
});
