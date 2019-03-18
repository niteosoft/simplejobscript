$(function() {
  $(".navbar-expand-toggle").click(function() {
    $(this).toggleClass("fa-rotate-90");
    $(".app-container").toggleClass("expanded");

    if ($(this).hasClass("fa-rotate-90")) {
      return $(this).html("<span class=\"fui-cross\"></span>");
    } else {
       return $(this).html("<span class=\"fui-list-thumbnailed\"></span>");
    }

  });
  return $(".navbar-right-expand-toggle").click(function() {
    $(".navbar-right").toggleClass("expanded");
    return $(".navbar-right-expand-toggle").toggleClass("fa-rotate-90");
  });
});

