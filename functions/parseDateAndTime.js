// take in a string like '2024-09-10 10:14:19' and return two strings like  '10/09/2024' and '10:14:00.0000000'

function parseDateAndTime(date) {
  // console.log("Here is the date object i got ");
  // console.log(date);
  const [datePart, timePart] = date.split(" ");
  const [year, month, day] = datePart.split("-");
  const [hours, minutes, seconds] = timePart.split(":");
  const amOrPm = hours >= 12 ? "PM" : "AM";
  const hours12 = hours % 12 || 12;
  const dateObject = {
    date: `${month}/${day}/${year}`,
    time: `${hours}:${minutes}`,
  };
  // console.log(dateObject.date);
  // console.log(dateObject.time);

  return dateObject;
}
