// function formatDate(str) {
// 	const date = new Date(str);
// 	const day = date.getDate();
// 	const month = date.getMonth() + 1;
// 	const year = date.getFullYear();
// 	return `${day}/${month}/${year}`;
// }
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
function processEmployees(data) {
  try {
    const currentYear = new Date().getFullYear();
    const groupedEmployees = {};

    data.forEach((employee) => {
      // Validate employee data
      if (!employee.dtStartDate) {
        throw new Error(`Missing start date for employee ID: ${employee.id}`);
      }

      const startYear = new Date(employee.dtStartDate).getFullYear();
      const yearsInService = currentYear - startYear;

      // Add years in service to employee object
      employee.yearsInService = yearsInService;

      // Group employees by years in service
      if (!groupedEmployees[yearsInService]) {
        groupedEmployees[yearsInService] = [];
      }
      groupedEmployees[yearsInService].push(employee);
    });

    // Sort each group by start date
    for (const years in groupedEmployees) {
      groupedEmployees[years].sort(
        (a, b) => new Date(a.dtStartDate) - new Date(b.dtStartDate)
      );
    }

    return groupedEmployees;
  } catch (error) {
    console.error("Error processing employees:", error.message);
    return null;
  }
}

async function renderAnniversaries() {
  await fetch("./API/getAnniversaries.php")
    .then((response) => response.json())
    .then((data) => {
      const groupedEmployees = processEmployees(data);
      console.log(groupedEmployees);
      let html = `<table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Date</th>
                            <th>Years</th>
                        </tr>
            `;
      for (const years in groupedEmployees) {
        html += `<tr class="yr${years}"><td colspan="4" class="table-headline">Employees with ${years} ${
          years === "1" ? "year" : "years"
        } of service:</td></tr>`;

        groupedEmployees[years].forEach((employee) => {
          html += `
                   <tr class="emp-card">
       		        <td class="name">${
                    employee.sFirstName.toLowerCase()
                      ? employee.sFirstName.toLowerCase()
                      : "Redacted"
                  } ${
            employee.sLastName.toLowerCase()
              ? employee.sLastName.toLowerCase()
              : "Classified"
          }</td>
       		        <td class="name">${
                    employee.sDepartmentName
                      ? employee.sDepartmentName
                      : "Not Assigned"
                  }</td>
       		        <td>${
                    parseDateForMonthAndDayOnly(employee.dtStartDate)
                      ? parseDateForMonthAndDayOnly(employee.dtStartDate)
                      : "Poop"
                  }</td>
                       <td>${
                         employee.yearsInService
                           ? employee.yearsInService
                           : "Oops"
                       } years</td>
       		    </tr>
       		`;
        });
      }

      html += "</table>";
      document.getElementById("anniversariesContent").innerHTML = html;
    })
    .catch((error) => {
      console.log(error);
    });
}
