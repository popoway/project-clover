function localizeFeedDate(date){
  var d = new Date(date + ' UTC');
  var dateString =
    d.getFullYear() + "/" +
    ("0" + (d.getMonth()+1)).slice(-2) + "/" +
    ("0" + d.getDate()).slice(-2) + " " +
    ("0" + d.getHours()).slice(-2) + ":" +
    ("0" + d.getMinutes()).slice(-2) + ":" +
    ("0" + d.getSeconds()).slice(-2);
  return dateString;
}

$(document).ready(function(){
  // Parse UTC feed date to local date
  $(".feed-date").each(function(index){
    $(this).text(localizeFeedDate($(this).text()));
  });
});
