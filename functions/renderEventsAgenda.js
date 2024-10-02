// get the data from the fetch request.
// Loop over the data, it should be sorted by date.
// Create an empty array of months.
// for each item in the array of data, add the value of the month to the months array, IF it is not already in there.
// Render a h3 with the month name, then each entry for that month ender the H3. Then render the entry.
// then render the next month.

function renderAgenda(data) {
  const months = [];
  // console.log(data);
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
    // console.log(monthName);
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
    const calendar = document.getElementById("eventsAgenda");
    const monthDiv = document.createElement("details");
    monthDiv.classList.add("month");
    monthDiv.innerHTML = `<summary class="month-title"> ${monthName}</div>`;
    calendar.appendChild(monthDiv);
    for (var i = 0; i < data.length; i++) {
      const date = new Date(data[i].dtStartDate);
      if (date.getMonth() === month) {
        const entry = document.createElement("div");
        entry.classList.add("entry");
        entry.classList.add(data[i].sStatus);
        entry.id = data[i].event_id;
        entry.innerHTML = `
        <p class="event-title col-span-2">${data[i].sTitle}</p>
        
        <div class="event-shifted">
            <p>Start:</p>
            <p> ${parseDateAndTime(data[i].dtStartDate).date} <b>@ </b> ${
          parseDateAndTime(data[i].dtStartDate).time
        }</p>
        </div>

        <div class="event-shifted">
            <p>End: </p>
            <p>${parseDateAndTime(data[i].dtEndDate).date} <b>@ </b> ${
          parseDateAndTime(data[i].dtEndDate).time
        }</p>
        </div>         
        
        <div class="event-shifted"> 
            <p>Created By:</p>
            <p>${data[i].iCreatedBy}</p>
        </div>

        <div class="event-shifted">
            <p>Status: </p>
            <p>${data[i].sStatus}</p>
        </div>
        
        <div class="event-shifted ">
            <p>Description: </p>
            <p></p> 
            </div>
        <p class="col-span-2">${data[i].sDescription}</p>
        
        <div class="notification-buttons-holder">
        
        
        <a class="btn btn-secondary btn-sm" href="editEventDetails.php?eventID=${
          data[i].event_id
        }">Edit</a>
        
        
        
       <button class="btn btn-danger btn-sm" type="button" 
          onclick="${
            data[i].sStatus === "active"
              ? "deleteNotification"
              : "recoverNotification"
          }('${data[i].id}')"
          id="button-${data[i].id}"
          >
          ${data[i].sStatus === "active" ? "Delete" : "Recover"}
        </button>
        </div>

        `;
        monthDiv.appendChild(entry);
      }
    }
  }
}
