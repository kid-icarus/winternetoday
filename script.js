$(document).ready(function () {
  var result = {};

  $.getJSON("api.php", function (json) {
    result = json;
    var source = $("#eattherich").html()
      , template = Handlebars.compile(source)
      , html = template(result);

      $("#appView").html(html);
  });

});
