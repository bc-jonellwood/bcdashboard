// get the data from the fetch request.
// Loop over the data, it should be sorted by date.
// Create an empty array of months.
// for each item in the array of data, add the value of the month to the months array, IF it is not already in there.
// Render a h3 with the month name, then each entry for that month ender the H3. Then render the entry.
// then render the next month.

function renderAgenda(data) {
  const months = [];
  console.log(data);
  for (var i = 0; i < data.length; i++) {
    const date = new Date(data[i].dtStartDate);
    const month = date.getMonth();
    if (!months.includes(month)) {
      months.push(month);
    }
  }
  //console.log("months");
  //console.log(months);

  for (var i = 0; i < months.length; i++) {
    const month = months[i];
    const monthName = getMonthName(month);
    console.log(monthName);
    renderMonth(monthName, data, month);
  }

  function getMonthName(month) {
    const monthNames = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];
    return monthNames[month];
  }

  function renderMonth(monthName, data, month) {
    const calendar = document.getElementById("calendar");
    const monthDiv = document.createElement("div");
    monthDiv.classList.add("month");
    monthDiv.innerHTML = `<div class="month-title"> ${monthName}</div>`;
    calendar.appendChild(monthDiv);
    for (var i = 0; i < data.length; i++) {
      const date = new Date(data[i].dtStartDate);
      if (date.getMonth() === month) {
        const entry = document.createElement("div");
        entry.classList.add("entry");
        entry.innerHTML = `
        <span class="notification-top-bar">
        <p class="notification-badge n-${data[i].sNotificationType}">-</p>
            <p class="notification-type"><b>Type: </b>${
              data[i].sNotificationType
            }</p>
            <p class="notification-date"><b>Start: </b> ${
              parseDateAndTime(data[i].dtStartDate).date
            }</p>
            
            <p class="notification-date"><b>End: </b> ${formatDate(
              data[i].dtEndDate
            )}</p>         
        </span>
        <span class="notification-top-bar"> 
            <p class="notification-created-by"><b>Created By: </b> ${
              data[i].iCreatedBy
            }</p>
            <p class="notification-time"><b>Time: </b> ${
              parseDateAndTime(data[i].dtStartDate).time
            }</p>
            <p class="notification-time"><b>Time: </b> ${
              parseDateAndTime(data[i].dtEndDate).time
            }</p>
        </span>
        <p class="notification-text">${data[i].sNotificationText}</p>
        `;
        monthDiv.appendChild(entry);
      }
    }
  }
}