var dmtech = (function ($) {

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
    return {
        comment: comment
    };
})(jQuery);
jQuery(document).ready(function () {
    dmtech.comment();
});
