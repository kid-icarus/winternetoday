$(document).ready(function () {
  var result = {};
  var today = new Date();
  var year = today.getFullYear();
  var month = today.getMonth() + 1;
  var day = today.getDate();
  var path = year + '-' + month + '-' + day;

  $.getJSON("public/data/" + path, renderz);
  $('#refTweets').hide();
  setTimeout(function() {
    $('#refTweets').show();
    $('#loading').remove();
  },3000);
});

function renderz(json) {
  var result = json;
  var source = $("#eattherich").html()
    , template = Handlebars.compile(source)
    , html = template(result);

  $("#appView").html(html);
  for (var i = 0; i < result.twitterIds.length; i++ ) {
    $.getJSON('https://api.twitter.com/1/statuses/oembed.json?id=' + result.twitterIds[i] + '&callback=?', function(tweetJson) {
      $('#refTweets').append(tweetJson.html);
    });
  }
}
