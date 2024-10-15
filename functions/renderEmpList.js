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
    const ulElement = document.getElementById('employee-list');
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
async function renderAllEmployeesAsSelect() {
  await getAllEmployees().then(() => {
    // const selectElement = document.getElementById("employees");
    const ulElement = document.getElementById('employee-as-list');
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
        selectUserAs(employee.userId, employee.sFirstName, employee.sLastName);
      });
      ulElement.appendChild(liElement);
    }
  });
}
renderAllEmployeesSelect();
// renderAllEmployeesAsSelect();

async function selectUser(userId, firstName, lastName) {
  const selectedHolder = document.getElementById("selected-holder");
  const ulElement = document.getElementById("employee-list");
  const inputElement = document.getElementById("empInput");
  inputElement.classList.add("hidden");
  ulElement.classList.add("hidden");
  var html = `
        <div>
            <span>Selected: </span>
           <p>${firstName} ${lastName}</p>
           <br>
           <button class="btn btn-warning" onclick="reset()">Start Over</button>
    `;
  selectedHolder.innerHTML = html;
  permissions = await getCurrentPermissions(userId);
  renderCurrentPermissions(permissions);
  renderAllEmployeesAsSelect();
  //   console.log(permissions);
}
async function selectUserAs(userId, firstName, lastName) {
  const selectedAsHolder = document.getElementById("selected-as-holder");
  var html = `
        <div>
            <span>Selected copy as: </span>
           <p>${firstName} ${lastName}</p>
           <br>
        </div>
    `;
  selectedAsHolder.innerHTML = html;
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
    <div class="form-check input-holder permission-item">
    <input type="checkbox" value=${permission.id} id="${permission.id}">
    <label class="form-check-label capitalize" for="${permission.id}" name="${
      permission.id
    }">
        ${removeUnderScore(permission.sNameAndAccess)} 
    </label>
    <button class="btn btn-primary btn-sm" value="${permission.id}" onclick="addPermissionToChangeList(event, '${permission.id}', 'add')">Add</button>
    <button class="btn btn-secondary btn-sm" value="${permission.id}" onclick="addPermissionToChangeList(event, '${permission.id}', 'remove')">Remove</button>
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
    // console.log(currentPermissions);
    permissions.forEach((permission) => {
      // console.log(permission);
      const checkboxId = permission.id; // get the value of the id of the checkbox so we can select that element
      const checkbox = document.getElementById(checkboxId); // this is the checkbox we want to check if the id exists in the current permissions array

      if (
        currentPermissions.some(
          (currentPermission) =>
            currentPermission.sFeatureAccessId === permission.id
        )
      ) {
        checkbox.checked = true;
      }
    });
  }
}

var permissionsToChange = [];
// function addPermissionToChangeList(event, permissionId, action) {
//   event.preventDefault();  
//   permissionsToChange.push(permissionId, action);
//   alert("Permission" + permissionId + " being " + action + "ed");
//   console.log(permissionsToChange);
// }

    // Array to hold the values of elements that are clicked
    // let permissionsToChange = [];

    // Function to handle the click event
    // function handlePermissionClick(event) {
    function addPermissionToChangeList(event, permissionId, action) {
        const clickedElement = event.target;
        //clickedElement.disabled = true;
        // console.log('If I fall back down...');
        // console.log(clickedElement.parentElement);
        const clickedParent = clickedElement.parentElement;
        const buttonsToDisable = clickedParent.querySelectorAll('.btn');
        buttonsToDisable.forEach(button => {
            button.disabled = true;
        })
        // Get the value from the clicked element (you can adjust based on your structure)
        const permissionValue = clickedElement.value;
        // Add the value to the permissionsToChange array
        permissionsToChange.push({permissionValue, action});
        // Get the parent element of the clicked element
        // Clone the clicked element to animate
        const clonedElement = clickedElement.parentElement.cloneNode(true);
        // Apply the slide animation to the cloned element
        clonedElement.classList.add('slide-element');
        // Append the cloned element to the body so it can slide across the screen
        document.body.appendChild(clonedElement);
        setTimeout(() => {
            var buttons = clonedElement.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.remove();
            })
            var checkbox = clonedElement.querySelector('input[type="checkbox"]');
            checkbox.remove();
            var label = clonedElement.querySelector('label');
            label.insertAdjacentText('afterbegin', action + ' ');
            var xBtn = document.createElement('button');
            xBtn.classList.add('btn', 'btn-danger', 'btn-sm');
            xBtn.textContent = 'X';
            xBtn.addEventListener('click', () => {
                var targetId = clonedElement.children[0].getAttribute('name');
                var restoreButtonsHolder = document.getElementById(targetId).parentElement;
                var buttonsToRestore = restoreButtonsHolder.querySelectorAll('.btn');
                buttonsToRestore.forEach(button => {
                  button.disabled = false;
                })
                clonedElement.remove();
                // Remove the value from the permissionsToChange array
                permissionsToChange = permissionsToChange.filter(permission => permission.permissionValue !== permissionId);
            });
            clonedElement.appendChild(xBtn);
            document.getElementById('pendingChangesList').appendChild(clonedElement);
            
        }, 500); // Matches the animation duration (1s)
    }

    // Add the click event listener to all elements within the div
    document.querySelectorAll('.permission-item').forEach(item => {
        item.addEventListener('click', handlePermissionClick);
    });

