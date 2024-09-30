let notificationDate = [];

async function getNotifications() {
  try {
    const response = await fetch("./API/getNotifications.php");
    const data = await response.json();
    console.log(data);
    renderAgenda(data);
    // Create an array of dates for each object
    const notificationDates = data.map((item) => {
      const startDate = new Date(item.dtStartDate);
      const endDate = new Date(item.dtEndDate);
      const dates = [];

      while (startDate <= endDate) {
        dates.push(startDate.toISOString());
        startDate.setDate(startDate.getDate() + 1);
      }

      return dates;
    });
    // console.log("notificationDate");
    console.log(notificationDates);
    return notificationDates;
  } catch (error) {
    console.log(error);
  }
}
