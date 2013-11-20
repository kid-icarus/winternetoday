$(document).ready(function () {
  $.getJSON("api.php", function (json) {
    console.log(json);
  });
});
