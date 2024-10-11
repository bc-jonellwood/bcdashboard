let allEmployees = [];
function addBlankSelectOption() {
  const selectElement = document.getElementById("employees");
  selectElement.innerHTML += `
    <option selected>Select an employee</option>
    `;
}
async function getAllEmployees() {
  await fetch("./API/getAllCurrentEmployees.php")
    .then((response) => response.json())
    .then((data) => {
      allEmployees = data;
      console.log(data);
    });
}

async function renderAllEmployeesSelect() {
  await getAllEmployees().then(() => {
    const selectElement = document.getElementById("employees");
    selectElement.innerHTML = "";
    addBlankSelectOption();
    for (let i = 0; i < allEmployees.length; i++) {
      const employee = allEmployees[i];
      const optionElement = document.createElement("option");
      optionElement.value = employee.iEmployeeNumber;
      optionElement.textContent = `${employee.sFirstName} ${employee.sLastName} (${employee.iEmployeeNumber})`;
      selectElement.appendChild(optionElement);
    }
  });
}
renderAllEmployeesSelect();
