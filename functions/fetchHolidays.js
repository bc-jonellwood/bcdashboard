function fetchHoliday() {
  fetch("./API/holidays.php")
    .then((response) => response.json())
    .then((data) => {
      console.log(data.date);
      renderHoliday(data);
    })
    .catch((error) => {
      console.log(error);
    });
}
