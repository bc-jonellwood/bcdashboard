let allEqEmployees = [];

async function getAllEmployees() {
  await fetch("./API/getAllCurrentEmployeesAndUsers.php")
    .then((response) => response.json())
    .then((data) => {
      allEqEmployees = data;
      // console.log(data);
    });
}

/**
 * Sorts an array of employee objects by last name in ascending order.
 * @param {object[]} employees - Array of employee objects with sLastName property.
 * @returns {object[]} - Sorted array of employee objects.
 */
function sortEmployeesByLastName(employees) {
  return employees.sort((a, b) => {
    const lastNameA = a.sLastName.toLowerCase();
    const lastNameB = b.sLastName.toLowerCase();

    if (lastNameA < lastNameB) {
      return -1;
    }
    if (lastNameA > lastNameB) {
      return 1;
    }
    return 0;
  });
}

/**
 * Renders a select element with options for each employee in the system.
 * @function renderSetupEqSelect
 * @async
 * @returns {Promise<void>}
 */
async function renderSetupEqSelect() {
  await getAllEmployees().then(() => {
    const sortedEmployees = sortEmployeesByLastName(allEqEmployees);
    // const selectElement = document.getElementById("employees");
    const ulElement = document.getElementById("setupEquivalent");
    // ulElement.classList.remove("hidden");
    ulElement.innerHTML = "";
    // selectElement.innerHTML = "";
    // addBlankSelectOption();
    var html = "<option value=''>Select Equivalent Access Rights</option>";
    for (let i = 0; i < sortedEmployees.length; i++) {
      const employee = sortedEmployees[i];
      html += `
        <option value="${employee.userId}">${
        employee.sPreferredName ? employee.sPreferredName : employee.sFirstName
      } ${employee.sLastName} (${employee.sEmployeeNumber})</option>
      `;
    }
    ulElement.innerHTML = html;
  });
}

renderAllEmployeesSelect();
