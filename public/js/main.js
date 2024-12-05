
// Filter News
$(document).ready(function () {
    $(".city-btn").click(function () {
      $(this).addClass("selected").siblings().removeClass("selected");
    });
  });
