function localizeFeedDate(date){
  var msec = Date.parse(date); // Parse date string to unix milliseconds
  var d = new Date(msec); // Then convert it to a date object
  var dateString =
    d.getFullYear() + "-" +
    ("0" + (d.getMonth()+1)).slice(-2) + "-" +
    ("0" + d.getDate()).slice(-2) + " " +
    ("0" + d.getHours()).slice(-2) + ":" +
    ("0" + d.getMinutes()).slice(-2) + ":" +
    ("0" + d.getSeconds()).slice(-2);
  return dateString;
}

function wordCount(){
  var c = $("#mainInput").val().length;
  if (c == 0) $("#mainInputHelp").text("随便说点什么吧～😉");
  else $("#mainInputHelp").text("Word Count: " + c);
}

function wordCountOnReset(){
  $("#mainInputHelp").text("随便说点什么吧～😉");
}

$(document).ready(function(){
  // construct EventListener for mainInput for wordCount
  document.getElementById("mainInput").addEventListener("input", wordCount);
  // Parse UTC feed date to local date
  $(".feed-date").each(function(index){
    $(this).text(localizeFeedDate($(this).text()));
  });
});
