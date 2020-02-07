var emc = (function($) {
  function dataTables() {
    $("#dtBasicExample").DataTable({
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Vietnamese.json"
      },
      scrollX: true
    });
  }
  function btn() {
    $("#file").prop("disabled", true);
    $(".info-account #btn_save").prop("disabled", true);
    $(".info-account #btn_cancel").css("display", "none");
    $(".info-account #btn_edit").click(function() {
      $(".info-account  #myEdit").attr("readonly", false);
      $(".info-account #btn_edit").css("display", "none");
      $(".info-account #btn_cancel").css("display", "inline-block");
      $(".info-account #btn_save").prop("disabled", false);
      $("#file").prop("disabled", false);
    });
    $(".info-account #btn_save").click(function() {
      $(".info-account #btn_cancel").css("display", "none");
      $(".info-account #btn_edit").css("display", "inline-block");
      $(".info-account #btn_save").prop("disabled", true);
      $(".info-account #myEdit").attr("readonly", true);
      $("#file").prop("disabled", true);
      alert("Cập nhật thông tin thành công!!! Lêu lêu");
    });
    $(".info-account #btn_cancel").click(function() {
      $(".info-account #btn_cancel").css("display", "none");
      $(".info-account #btn_edit").css("display", "inline-block");
      $(".info-account #myEdit").attr("readonly", true);
      $(".info-account #btn_save").prop("disabled", true);
      $("#file").prop("disabled", true);
    });

    $(".reveal .weeping").css("display", "none");
    $(".reveal").on("click", function() {
      var $pwd = $(".pwd");
      if ($pwd.attr("type") === "password") {
        $pwd.attr("type", "text");
        $(".reveal .view").css("display", "none");
        $(".reveal .weeping").css("display", "block");
      } else {
        $pwd.attr("type", "password");
        $(".reveal .view").css("display", "block");
        $(".reveal .weeping").css("display", "none");
      }
    });
    $(".owl-carousel").owlCarousel({
      loop: true,
      margin: 10,
      responsiveClass: true,
      nav: true,
      // autoplay: true,
      responsive: {
        0: {
          items: 1,
          nav: true
        },
        600: {
          items: 3,
          nav: true
        },
        1000: {
          items: 4,
          nav: true,
          loop: true
        }
      }
    });
  }
  function menu() {
    $(".navbar-toggler#close").css("display", "none");
    $("#open").click(function() {
      $("#navbarSupportedContent").css({
        width: "230px",
        transition: "width .4s"
      });
      $("#wrapper").addClass("out");
      $("#wrapper").css({
        // left: "230px",
        position: "relative",
        transition: "left .4s"
      });
      $(".navbar-toggler#close").css("display", "block");
      $("#open").css("display", "none");
      $("#open-left").css("display", "none");
    });
    $("#open-left").click(function() {
      $("#navbarservices").css({
        width: "230px",
        transition: "width .4s"
      });
      $("#wrapper").addClass("out");
      $("#wrapper").css({
        // left: "230px",
        position: "relative",
        transition: "left .4s"
      });
      $(".navbar-toggler#close").css("display", "block");
      $("#open-left").css("display", "none");
    });
    $(".navbar-toggler#close").click(function() {
      $(".navbar-collapse.collapse.show#navbarservices").css({
        width: "0px",
        transition: "width .4s"
      });
      $("#wrapper").css({
        left: "0px",
        position: "relative",
        transition: "left .4s"
      });
      $("#close").css("display", "none");
      $("#open").css("display", "block");
      $("#open-left").css("display", "block");
      $("#wrapper").removeClass("out");
    });

    value = 991;
    if ($(window).width() < value) {
      $("#navbarSupportedContent").addClass("show");
      $("#navbarservices").addClass("show");
    }
    $(".navbar-collapse.collapse.show#navbarservices").css({
      bottom: "0px",
      left: "0px",
      width: "0px",
      position: "fixed",
      overflow: "hidden",
      top: "0",
      background: "#dc3545",
      "z-index": "99"
    });
    $("#summernote").summernote({
      tabsize: 2,
      height: 150
    });
  }
  return {
    dataTables: dataTables,
    btn: btn,
    menu: menu
  };
})(jQuery);
jQuery(document).ready(function() {
  emc.dataTables();
  emc.btn();
  emc.menu();
});
