let allEmployees = [];
let permissions = [];
// function addBlankSelectOption() {
//   const selectElement = document.getElementById("employees");
//   selectElement.innerHTML += `
//     <option selected>Select an employee</option>
//     `;
// }
async function getAllEmployees() {
  await fetch("./API/getAllCurrentEmployeesAndUsers.php")
    .then((response) => response.json())
    .then((data) => {
      allEmployees = data;
      //   console.log(data);
    });
}

async function renderAllEmployeesSelect() {
  await getAllEmployees().then(() => {
    // const selectElement = document.getElementById("employees");
    const ulElement = document.getElementById("employee-list");
    // ulElement.classList.remove("hidden");
    ulElement.innerHTML = "";
    // selectElement.innerHTML = "";
    // addBlankSelectOption();
    for (let i = 0; i < allEmployees.length; i++) {
      const employee = allEmployees[i];
      const liElement = document.createElement("li");
      //   liElement.dataset.userId = employee.userId;
      liElement.textContent = `${employee.sFirstName} ${employee.sLastName} (${employee.sEmployeeNumber})`;
      liElement.addEventListener("click", () => {
        selectUser(employee.userId, employee.sFirstName, employee.sLastName);
      });
      ulElement.appendChild(liElement);
    }
  });
}
renderAllEmployeesSelect();

async function selectUser(userId, firstName, lastName) {
  const selectedHolder = document.getElementById("selected-holder");
  const ulElement = document.getElementById("employee-list");
  const inputElement = document.getElementById("empInput");
  inputElement.classList.add("hidden");
  ulElement.classList.add("hidden");
  var html = `
        <div>
            <span>Yayyyyyy you selected </span>
           <p>${firstName} ${lastName}</p>
           <br>
           <button class="btn btn-warning" onclick="reset()">Start Over</button>
    `;
  selectedHolder.innerHTML = html;
  permissions = await getCurrentPermissions(userId);
  renderCurrentPermissions(permissions);
  //   console.log(permissions);
}

function reset() {
  document.getElementById("selected-holder").innerHTML = "";
  document.getElementById("empInput").classList.remove("hidden");
  document.getElementById("empInput").value = "";
  document.getElementById("employee-list").classList.add("hidden");
  document.getElementById("currentAccessList").innerHTML = "";
  renderAllEmployeesSelect();
}

function renderCurrentPermissions(permissions) {
  //   console.log("permissions in the render function");
  //   console.log(permissions[0].permissions);
  //   console.log(permissions);
  var target = document.getElementById("currentAccessList");
  target.innerHTML = "";
  var html = "";
  for (let i = 0; i < permissions[0].permissions.length; i++) {
    const permission = permissions[0].permissions[i];
    // console.log("I AM SO ANGRY");
    // console.log(permission);
    html += `
    <div class="form-check">
    <input type="checkbox" value=${permission.id} id="${permission.id}">
    <label class="form-check-label capitalize" for="${permission.id}" name="${
      permission.id
    }">
        ${removeUnderScore(permission.sNameAndAccess)} 
    </label>
    </div>
    `;
  }
  target.innerHTML = html;
  checkboxIfPermissionExists(permissions);
}

function checkboxIfPermissionExists(permissionsData) {
  const permissions = permissionsData[0].permissions;
  //   console.log(permissions);
  const currentPermissions = permissionsData[1].current_permissions;
  //   console.log(currentPermissions);

  if (Array.isArray(currentPermissions) && currentPermissions.length > 0) {
    // check for existing
    permissions.forEach((permission) => {
      //   const checkboxId = `checkbox_${permission.id}`;
      const checkboxId = permission.id;
      console.log(checkboxId);
      const checkbox = document.getElementById(checkboxId);

      if (checkbox && currentPermissions.includes(permission.id)) {
        checkbox.checked = true;
      }
    });
  }
}

//  <ul id="employee-list" class="list-group list-group-flush">
//    <li data-user-id="AE447EA8-030F-47A2-90B8-DB138DFE9052">
//      EMILY ALBER (8414)
//    </li>
//    <li data-user-id="4735E527-D96C-4AAF-B850-D1269969E1CD">
//      CATHERINE LECKIE (8396)
//    </li>
//    <li data-user-id="0528ED4E-5F96-425D-9156-0A237667513A">
//      MONIQUE PETERSON (8420)
//    </li>
//    <li data-user-id="35E8FBAB-183F-4319-832F-6164E40A66C8">
//      CHRISTOPHER REGINA (8405)
//    </li>
//  </ul>;
