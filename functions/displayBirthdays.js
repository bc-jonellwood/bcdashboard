function parseDateForMonthAndDayOnly(date) {
  const [year, month, day] = date.split("-");
  return `${month}/${day}`;
}
function parseDateForYearOnly(date) {
  const [year, month, day] = date.split("-");
  return `${year}`;
}
function calculateYears(date) {
  const today = new Date();
  const anniverdaryDate = new Date(date);
  let years = today.getFullYear() - anniverdaryDate.getFullYear();
  const m = today.getMonth() - anniverdaryDate.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < anniverdaryDate.getDate())) {
    years--;
  }
  return years;
}

async function renderBirthdays() {
  await fetch("./API/getBirthdays.php")
    .then((response) => response.json())
    .then((data) => {
      let html = `<table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Birthday</th>
                        </tr>
            `;
      for (var i = 0; i < data.length; i++) {
        html += `
                   <tr class="emp-card">
       		        <td class="name">${
                    data[i].sFirstName.toLowerCase()
                      ? data[i].sFirstName.toLowerCase()
                      : "Redacted"
                  } ${
          data[i].sLastName.toLowerCase()
            ? data[i].sLastName.toLowerCase()
            : "Classified"
        }</td>
       		        <td class="name">${
                    data[i].sDepartmentName
                      ? data[i].sDepartmentName
                      : "Not Assigned"
                  }</td>
       		        <td>${
                    parseDateForMonthAndDayOnly(data[i].dtDateOfBirth)
                      ? parseDateForMonthAndDayOnly(data[i].dtDateOfBirth)
                      : "Raisin Bran"
                  }</td>
       		    </tr>
       		`;
      }
      //   }

      html += "</table>";
      document.getElementById("birthdaysContent").innerHTML = html;
    })
    .catch((error) => {
      console.log(error);
    });
}
