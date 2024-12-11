function formatDateTime(dateTimeString) {
  var date = new Date(dateTimeString);
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? "PM" : "AM";
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes.toString().padStart(2, "0");
  // var formattedDateTime = date.getFullYear() + '/' + date.getMonth() + '/' + date.getDate() + ' ' + hours + ':' + minutes + ' ' + ampm;
  var formattedDateTime =
    date.getMonth() +
    "/" +
    date.getDate() +
    "/" +
    date.getFullYear() +
    " " +
    hours +
    ":" +
    minutes +
    " " +
    ampm;
  return formattedDateTime;
}
// function to make minutes human readable
function calculateMinToHumanReadable(min) {
  var hours = Math.floor(min / 60);
  var minutes = min % 60;
  var days = Math.floor(hours / 24);
  var years = Math.floor(days / 365);

  if (years > 0) {
    days = days % 365; // Only modify days after extracting years
    return (
      years.toLocaleString() +
      " years " +
      days.toLocaleString() +
      " days " +
      (hours % 24) +
      " hours " +
      minutes +
      " minutes"
    );
  } else if (days > 0) {
    return (
      days.toLocaleString() +
      " days " +
      (hours % 24) +
      " hours " +
      minutes +
      " minutes"
    );
  } else {
    return hours.toLocaleString() + " hours " + minutes + " minutes";
  }
}
// function to calclate the time difference between a date string and now
function calcTimeBetween(str) {
  var dateA = new Date(str);
  var dateB = new Date();
  var diff = dateB - dateA;
  var diffInMinutes = Math.floor(diff / 60000);
  return calculateMinToHumanReadable(diffInMinutes);
}
