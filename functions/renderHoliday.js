function renderHoliday(data) {
  const holiday = document.getElementById("holiday");
  const holidayName = data.name;
  const holidayDate = data.date;
  const daysUntilHoliday = data.daysUntil;

  // holiday.innerHTML = `
  //   <p class="days-until-holiday">${daysUntilHoliday} days left</p>
  //   <p class="holiday-name"> until ${holidayName}</p>
  //   <p class="holiday-date"> on ${holidayDate}</p>
  //   `;
  holiday.innerHTML = `
    <p class="days-until-holiday">${daysUntilHoliday} days left
    until ${holidayName}</br>
     on ${holidayDate}</p>  
    `;
}
