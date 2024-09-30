// takes  a string like '00:00:00.0000000' and returns '00:00 AM'

function parseTime(str) {
  const [hours, minutes, seconds] = str.split(":");
  const amOrPm = hours >= 12 ? "PM" : "AM";
  const hours12 = hours % 12 || 12;
  return `${hours12}:${minutes} ${amOrPm}`;
}
