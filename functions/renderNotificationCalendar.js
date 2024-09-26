function renderCalendar(data) {
  const calendar = document.getElementById("calendar");
  const days = [
    "Sunday",
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday",
  ];

  // Clear existing calendar content
  calendar.innerHTML = "";

  // Get the current date
  const currentDate = new Date();

  // Create a new Date object for the first day of the month
  const firstDayOfMonth = new Date(
    currentDate.getFullYear(),
    currentDate.getMonth(),
    1
  );

  // Get the day of the week for the first day of the month
  const firstDayOfWeek = firstDayOfMonth.getDay();

  // Calculate the number of days in the previous month
  const prevMonthDays = new Date(
    currentDate.getFullYear(),
    currentDate.getMonth(),
    0
  ).getDate();

  // Create the calendar header
  const header = document.createElement("div");
  header.classList.add("calendar-header");

  const prevMonthButton = document.createElement("button");
  prevMonthButton.classList.add("prev-month", "btn");
  prevMonthButton.textContent = "<";
  prevMonthButton.addEventListener("click", () => {
    const prevMonth = new Date(
      currentDate.getFullYear(),
      currentDate.getMonth() - 1,
      1
    );
    renderCalendar(data, prevMonth);
  });

  const monthYear = document.createElement("span");
  monthYear.textContent = currentDate.toLocaleString("default", {
    month: "long",
    year: "numeric",
  });

  const nextMonthButton = document.createElement("button");
  nextMonthButton.classList.add("next-month", "btn");
  nextMonthButton.textContent = ">";
  nextMonthButton.addEventListener("click", () => {
    const nextMonth = new Date(
      currentDate.getFullYear(),
      currentDate.getMonth() + 1,
      1
    );
    renderCalendar(data, nextMonth);
  });

  header.appendChild(prevMonthButton);
  header.appendChild(monthYear);
  header.appendChild(nextMonthButton);

  calendar.appendChild(header);

  // Create the calendar body
  const body = document.createElement("div");
  body.classList.add("calendar-body");

  // Create the calendar table
  const table = document.createElement("table");
  table.classList.add("calendar-table");

  // Create the table header
  const thead = document.createElement("thead");
  const headerRow = document.createElement("tr");

  for (let i = 0; i < 7; i++) {
    const th = document.createElement("th");
    th.textContent = days[i];
    headerRow.appendChild(th);
  }

  thead.appendChild(headerRow);
  table.appendChild(thead);

  // Create the table body
  const tbody = document.createElement("tbody");

  // Create empty cells for the previous month
  const prevMonthCells = document.createElement("tr");
  for (let i = 0; i < firstDayOfWeek; i++) {
    const td = document.createElement("td");
    td.classList.add("prev-month");
    prevMonthCells.appendChild(td);
  }

  // Create cells for the current month
  let dayCount = 1;
  let currentRow = document.createElement("tr");
  for (let i = firstDayOfWeek; i < 7; i++) {
    const td = document.createElement("td");
    td.textContent = dayCount;

    // Check if there are any events for this day
    const events = data.filter((event) => {
      const eventDate = new Date(event.dtStartDate);

      return (
        eventDate.getDate() === dayCount &&
        eventDate.getMonth() === currentDate.getMonth()
      );
    });
    if (events.length > 0) {
      td.classList.add("event");
      const eventList = document.createElement("ul");
      // Find the event that spans the most days
      const longestEvent = events.reduce(
        (longest, event) => {
          const startDate = new Date(event.dtStartDate);
          const endDate = new Date(event.dtEndDate);
          const duration = (endDate - startDate) / (1000 * 60 * 60 * 24);
          return duration > longest.duration ? { event, duration } : longest;
        },
        { event: null, duration: 0 }
      );
      // set rowspan
      if (longestEvent.event) {
        const startDate = new Date(longestEvent.event.dtStartDate);
        const endDate = new Date(longestEvent.event.dtEndDate);
        const duration = (endDate - startDate) / (1000 * 60 * 60 * 24);
        td.rowSpan = duration + 1;
        // td.setAttribute("rowspan", duration);
      }
      events.forEach((event) => {
        const li = document.createElement("li");
        li.textContent = event.sNotificationText;
        eventList.appendChild(li);
      });
      td.appendChild(eventList);
    }
    currentRow.appendChild(td);
    dayCount++;
  }
  tbody.appendChild(prevMonthCells);
  tbody.appendChild(currentRow);
  table.appendChild(tbody);

  // Add the table to the calendar
  body.appendChild(table);
  calendar.appendChild(body);

  // Add the calendar to the page
  //   document.getElementById("recentNotificationsContent").appendChild(calendar);
}
