var emc = (function ($) {
    function dataTables() {
        $('#table-library').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Vietnamese.json"
            },
            // responsive: true,
        });
    }
    function file() {
        $('#file').on('change', function () {
            var fileName = $(this).val();
            $(this).next('.custom-file-label').html(fileName);
        })
    }
    function comment() {
        $('.replybutton').click(function (e) {
            e.preventDefault();
            var $this = $(this);
            $('#formComment')[0].reset();

            $('textarea', this).focus();
            if ($this.next().hasClass('show')) {
                $this.next().removeClass('show');
                $this.next().slideUp(350);
            } else {
                $this.parent().parent().find('.reply').removeClass('show');
                $this.parent().parent().find('.reply').slideUp(350);
                $this.next().toggleClass('show');
                $this.next().slideToggle(350);
            }
        });
    }
    function call() {
        $('#float-contact').hide();
        $("#show-contact").click(function () {
            if ($('#show-contact').hasClass('up')) {
                $('#float-contact').slideUp(400);
                $('#show-contact').removeClass('up');
            } else {
                $('#float-contact').slideDown(400);
                $('#show-contact').addClass('up');
            }
        });
        var toggleShowHidden = document.getElementById('js-toggleShowHidden')
        var toggleItem = document.getElementsByClassName('toggle')

        toggleShowHidden.onclick = function () {
            for (let index = 0; index < toggleItem.length; index++) {
                toggleItem[index].classList.toggle('show')
            }
        }
    }
    function removeTable() {
        $(".btn-delete").click(function (event) {
            $(this).closest('table').remove();
        });
    }
    function toTop() {
        var btn = $('#button-to-top');

        $(window).scroll(function () {
            if ($(window).scrollTop() > 300) {
                btn.addClass('show');
            } else {
                btn.removeClass('show');
            }
        });

        btn.on('click', function (e) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: 0 }, '500');
        });
    }
    function cartScroll() {
        var cart = $('#cart-scroll');

        $(window).scroll(function () {
            if ($(window).scrollTop() > 300) {
                cart.addClass('show');
            } else {
                cart.removeClass('show');
            }
        });

    }

    return {
        dataTables: dataTables,
        comment: comment,
        file: file,
        call: call,
        removeTable: removeTable,
        toTop: toTop,
        cartScroll: cartScroll

    };
})(jQuery);
jQuery(document).ready(function () {
    emc.dataTables();
    emc.comment();
    emc.file();
    emc.call();
    emc.removeTable();
    emc.toTop();
    emc.cartScroll();
});
