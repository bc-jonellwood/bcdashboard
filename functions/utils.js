// function to take a string like '2024-09-10 10:14:19' and return '10/09/2024'

function formatDate(str) {
  const date = new Date(str);
  const day = date.getDate();
  const month = date.getMonth() + 1;
  const year = date.getFullYear();
  return `${month}/${day}/${year}`;
}
function removeLoDash(input) {
  var cleaned = input.replace(/_/g, " ");
  return cleaned;
}

function returnMonth() {
  const date = new Date();
  const month = date.getMonth() + 1;
  return month;
}
function returnDay() {
  const date = new Date();
  const day = date.getDate();
  return day;
}
