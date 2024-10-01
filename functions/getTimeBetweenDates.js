// take in two strings like '2024-09-10' and calculate the duration in hours between them

function getTimeBetweenDates(date1, time1, date2, time2) {
  //   console.log("date1", date1);
  //   console.log("date2", date2);
  //   console.log("time1", time1);
  //   console.log("time2", time2);
  const startDate = new Date(date1);
  const startTime = new Date(`${date1} ${time1}`);
  const endDate = new Date(date2);
  const endTime = new Date(`${date2} ${time2}`);
  const diffTime = Math.abs(endTime - startTime);
  const diffHours = Math.ceil(diffTime / (1000 * 60 * 60));
  return diffHours;
}
