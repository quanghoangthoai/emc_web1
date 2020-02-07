var app = {
    /**
     * Show notification
     * @param {*} message
     * @param {*} type
     */
    showNotify: function (message, type = "info") {
        var icon_before = "";
        if (type == "success") {
            icon_before = '<em class="fa fa-check"></em>';
        }
        if (type == "error") {
            icon_before = '<em class="fa fa-times-circle"></em>';
        }
        if (type == "warning") {
            icon_before = '<em class="icon-warning22"></em>';
        }
        if (type == "info") {
            icon_before = '<em class="fa fa-info"></em>';
        }
        new Noty({
            theme: "metroui",
            timeout: 5000,
            layout: "bottomRight",
            text: icon_before + "&nbsp;&nbsp;&nbsp;&nbsp;" + message,
            type: type
        }).show();
    }
};

Array.prototype.unique = function () {
    var a = this.concat();
    for (var i = 0; i < a.length; ++i) {
        if (typeof a[i] === typeof undefined) {
            a.splice(j--, 1);
        } else {
            for (var j = i + 1; j < a.length; ++j) {
                if (a[i] === a[j])
                    a.splice(j--, 1);
            }
        }
    }

    return a;
};

/**
 * Ask to make sure before redirect to uninstall module
 * @param {*} element
 */
function askToUninstallMod(element) {
    if (
        confirm(
            "Tất cả dữ liệu liên quan sẽ bị xóa và không thể khôi phục. Bạn có chắc chắn muốn gỡ cài đặt module này?"
        )
    ) {
        window.location.href = $(element).data("href");
    }
    return false;
}

/**
 * Ask to make sure before redirect to a delete route
 * @param {*} element
 */
function askToDelete(element) {
    if (confirm("Dữ liệu sẽ không thể khôi phục. Bạn có chắc chắn muốn xóa?")) {
        window.location.href = $(element).data("href");
    }
    return false;
}

function get_slug(elTitle, elSlug) {
    $.ajax({
        type: "post",
        url: "/getslug",
        data: {
            _token: _token,
            plainText: $(elTitle).val()
        },
        dataType: "JSON",
        success: function (data) {
            $(elSlug).val(data);
        }
    });
}

function display_timer_header() {
    var x = new Date();
    var month = x.getMonth() + 1;
    var day = x.getDate();
    var year = x.getFullYear();
    if (month < 10) {
        month = "0" + month;
    }
    if (day < 10) {
        day = "0" + day;
    }
    var x3 = day + "/" + month + "/" + year;

    // time part //
    var hour = x.getHours();
    var minute = x.getMinutes();
    var second = x.getSeconds();
    if (hour < 10) {
        hour = "0" + hour;
    }
    if (minute < 10) {
        minute = "0" + minute;
    }
    if (second < 10) {
        second = "0" + second;
    }
    var x3 = x3 + ", " + hour + ":" + minute + ":" + second;
    $("#timer_header").html(x3);
    setTimeout(function () {
        display_timer_header();
    }, 1000);
}

function number_format(nStr) {
    nStr += "";
    x = nStr.split(".");
    x1 = x[0];
    x2 = x.length > 1 ? "." + x[1] : "";
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, "$1" + "," + "$2");
    }
    return x1 + x2;
}

function fmSetLink($url, id = "") {
    $("#" + id).val($url.replace(app_url, "")).trigger("change");
    $("#modalSelectFile").modal("hide");
}

/*
 *Makes a tab and it's content incactive
 */
function makeInactive(items) {
    const content = Object.keys(items).map(item => {
        $(items[item]).removeClass("active show");
    });
}

/*
 * Display the selected tab content.
 */
function activateTabContent(e) {
    // gets the element on which the event originally occurred
    const anchorReference = e.target;
    const activePaneID = anchorReference.getAttribute("href");
    const el = document.getElementById(activePaneID);
    $(el).addClass("active show");
}

var listSelectedItem = [];

function openInsertProduct2Content() {
    $.ajax({
        type: "post",
        url: url_ajax_modal_product,
        data: {
            _token: _token
        },
        dataType: "JSON",
        success: function (res) {
            $("#modalInsertProduct2Content .modal-body").html(res);
            $("#modalInsertProduct2Content").modal("show");
            const myTabs = document.querySelectorAll("ul.nav-tabs > li > a");
            const panes = document.querySelectorAll(".tab-pane");
            const tabAction = Object.keys(myTabs).map(tab => {
                myTabs[tab].addEventListener("click", e => {
                    makeInactive(panes);
                    activateTabContent(e);
                    e.preventDefault();
                });
            });

            listSelectedItem = [];

            $(".btnInsertShortcodeProduct").click(e => {
                var ids = listSelectedItem.join(",");
                if (ids == "") alert("Chưa chọn sản phẩm nào");
                else {
                    var shortcode = '<p>[product ids="' + ids + '"]</p><br>';
                    $("#modalInsertProduct2Content").modal("hide");
                    CKEDITOR.instances.content.insertHtml(shortcode);
                }
            });

            $(".itemSelectProduct").click(e => {
                if (!$(e.currentTarget).hasClass("bg-dark")) {
                    var html =
                        '<div class="media itemSelected" style="display:none;">' +
                        '<div class="col-left">' +
                        '<button class="btn btn-light dragula-handle"><i class="icon-dots"></i></button>' +
                        '<button class="btn btn-danger btn-remove-selected-item" data-id="' +
                        $(e.currentTarget).data("id") +
                        '"><i class="fa fa-trash-alt"></i></button>' +
                        "</div>" +
                        '<div class="col-right">' +
                        $(e.currentTarget)
                        .find(".html-info")
                        .first()
                        .html() +
                        "</div></div>";
                    $(e.currentTarget).addClass("bg-dark");
                    $("#listSelectedItem").append(html);
                    $("#listSelectedItem .itemSelected:last-child").fadeIn(300);
                    $("#listSelectedItem").scrollTop(
                        $("#listSelectedItem")[0].scrollHeight
                    );

                    // dragula([document.getElementById("listSelectedItem")], {
                    //     mirrorContainer: document.querySelector(
                    //         "listSelectedItem"
                    //     ),
                    //     moves: function(el, container, handle) {
                    //         return handle.classList.contains("dragula-handle");
                    //     }
                    // });

                    // DragAndDrop.init();

                    listSelectedItem.push($(e.currentTarget).data("id"));

                    $(".btn-remove-selected-item").click(e => {
                        $(
                            "#itemProduct_" + $(e.currentTarget).data("id")
                        ).removeClass("bg-dark");
                        $(e.currentTarget)
                            .parent()
                            .parent()
                            .remove();
                        for (var i = 0; i < listSelectedItem.length; i++) {
                            if (
                                listSelectedItem[i] ===
                                $(e.currentTarget).data("id")
                            ) {
                                listSelectedItem.splice(i, 1);
                            }
                        }
                    });
                }
            });
        }
    });
}

function setSwitchery(switchElement, checkedBool) {
    if (
        (checkedBool && !switchElement.isChecked()) ||
        (!checkedBool && switchElement.isChecked())
    ) {
        switchElement.setPosition(true);
        switchElement.handleOnchange(true);
    }
}

function loading(el) {
    $(el).block({
        message: '<i class="icon-spinner2 spinner"></i>',
        overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.8,
            cursor: 'wait'
        },
        css: {
            border: 0,
            padding: 0,
            backgroundColor: 'none'
        }
    });
}

$(document).ready(function () {
    display_timer_header();

    var switches = Array.prototype.slice.call(
        document.querySelectorAll(".form-input-switchery")
    );
    switches.forEach(function (html) {
        var switchery = new Switchery(html, {
            secondaryColor: "#d8201c"
        });
    });

    $(".btn-choose-file").click(e => {
        if (typeof $(e.target).data("id") !== typeof undefined) {
            $("#modalSelectFile .modal-body").html("");
            $("#modalSelectFile .modal-body").html(
                '<iframe src="/file-manager/fm-button?id=' +
                $(e.target).data("id") +
                '" frameborder="0" style="width:100%;height:100%"></iframe>'
            );
            $("#modalSelectFile").modal("show");
        }
    });
    $(".btn-remove-file").click(e => {
        $(e.target)
            .parent()
            .parent()
            .parent()
            .find("input")
            .first()
            .val("").trigger("change");
    });
});
