let allEmployees = [];
let permissions = [];

async function getAllEmployees() {
  await fetch("./API/getAllCurrentEmployeesAndUsers.php")
    .then((response) => response.json())
    .then((data) => {
      allEmployees = data;
      // console.log(data);
    });
}

async function renderAllEmployeesSelect() {
  await getAllEmployees().then(() => {
    const ulElement = document.getElementById("employee-list");
    ulElement.innerHTML = "";
    for (let i = 0; i < allEmployees.length; i++) {
      const employee = allEmployees[i];
      const liElement = document.createElement("li");
      //   liElement.dataset.userId = employee.userId;
      liElement.textContent = `${
        employee.sPreferredName ? employee.sPreferredName : employee.sFirstName
      } ${employee.sLastName} (${employee.sEmployeeNumber})`;
      liElement.addEventListener("click", () => {
        selectAsNewUser(
          employee.userId,
          employee.sFirstName,
          employee.sLastName,
          employee.sEmployeeNumber,
          employee.iDepartmentNumber,
          employee.sDepartmentName,
          employee.dtStartDate,
          employee.sMiddleName,
          employee.sPreferredName
        );
      });
      ulElement.appendChild(liElement);
    }
  });
}

renderAllEmployeesSelect();

async function selectAsNewUser(
  userId,
  firstName,
  lastName,
  employeeNumber,
  departmentNumber,
  departmentName,
  startDate,
  middleName,
  preferredName
) {
  const selectedHolder = document.getElementById("selected-holder");
  const ulElement = document.getElementById("employee-list");
  const inputElement = document.getElementById("empInput");
  const inputLabel = document.getElementById("selectEmpLabel");
  const newUserRequestForm = document.getElementById("newUserRequestForm");
  const disclaimerText = document.getElementById("disclaimer");
  inputElement.classList.add("hidden");
  ulElement.classList.add("hidden");
  inputLabel.classList.add("hidden");
  disclaimerText.classList.add("hidden");
  newUserRequestForm.classList.remove("hidden");
  newUserRequestForm.classList.add("newUserRequestFormShow");
  var html = `
   <button class="btn btn-warning" onclick="reset()">Start Over</button>
        <div class="selected-holder">
        <input type="hidden" name="newUserId" id="newUserId" value="${userId}">
            <span class="d-flex justify-content-start flex-row">Selected: ${
              firstName.toLowerCase() ? firstName.toLowerCase() : " "
            } ${middleName.toLowerCase() ? middleName.toLowerCase() : " "}  ${
    lastName.toLowerCase() ? lastName.toLowerCase() : " "
  } - <p id="newUserRequestEmployeeNumber">${
    employeeNumber ? employeeNumber : ""
  } </p></span>
            <span class="d-flex justify-content-start flex-row">Preferred Name: ${
              preferredName ? preferredName.toLowerCase() : ""
            }</span>
            <span class="d-flex justify-content-start flex-row">Department: ${
              departmentName ? departmentName : ""
            } (${departmentNumber ? departmentNumber : ""}) </span>
            <span class="d-flex justify-content-start flex-row">Start Date: ${
              startDate ? startDate : ""
            }</span>
            
        </div>
    `;
  selectedHolder.innerHTML = html;
  generateAccessChecklist("employeeAccessRights");
}

function reset() {
  document.getElementById("selected-holder").innerHTML = "";
  document.getElementById("empInput").classList.remove("hidden");
  document.getElementById("selectEmpLabel").classList.remove("hidden");
  document.getElementById("empInput").value = "";
  document.getElementById("employee-list").classList.add("hidden");
  document.getElementById("newUserRequestForm").classList.add("hidden");
  document.getElementById("disclaimer").classList.remove("hidden");
  console.log(document.getElementById("disclaimer"));
  document
    .getElementById("newUserRequestForm")
    .classList.remove("newUserRequestFormShow");

  renderAllEmployeesSelect();
}
