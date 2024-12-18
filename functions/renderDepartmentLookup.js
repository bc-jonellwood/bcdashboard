function lookupEmployees(departmentID) {
  //   console.log(name);
  fetch("/API/getAllEmployeesInDepartment.php?departmentID=" + departmentID)
    .then((response) => response.json())
    .then((data) => {
      // console.log(data);
      if (data.length > 0) {
        var html = "";
        for (var i = 0; i < data.length; i++) {
          html += `
                        <div class="employee-card">
                            <div class="employee-card-body">
                                <p class="employee-card-name">${data[
                                  i
                                ].sFirstName.toLowerCase()} ${data[
            i
          ].sLastName.toLowerCase()} </p>
                                <p class="employee-card-phone">${
                                  data[i].sMainPhoneNumber
                                }</p>
                            </div>  
                        </div>
                    `;
        }
        document.getElementById("department-lookup-results").innerHTML = html;
      } else {
        document.getElementById("department-lookup-results").innerHTML =
          "No results found";
      }
    })
    .catch((error) => {
      console.log(error);
    });
}

// function clearEmployeeLookup() {
//   document.getElementById("employee-lookup-first-name").value = "";
//   document.getElementById("employee-lookup-last-name").value = "";
//   document.getElementById("employee-lookup-results").innerHTML = "";
// }
let departments = [];
async function getAllDepartments() {
  await fetch("/API/getAllDepartments.php")
    .then((response) => response.json())
    .then((data) => {
      departments = data;
    });
}
async function renderDepartmentLookup() {
  await getAllDepartments();
  //   console.log("D-D-D-Departments");
  // console.log(departments);
  var html = `
    <div class="employee-lookup">
        <div class="employee-lookup-body">
            <div class="employee-lookup-card">
                <div class="employee-lookup-card-body">
                    <div class="input-group mb-3">
                       <select class="form-select" onchange="lookupEmployees(this.value)">
                            `;
  for (var i = 0; i < departments.length; i++) {
    html += `   
                                    <option value="${departments[i].iDepartmentNumber}">${departments[i].sDepartmentName}</option>
                                    `;
  }
  html += `</select>
                    </div>
                </div>
            </div>
            <div class="popover-btn-holder">
            <button class="btn btn-danger btn-small employee-lookup-clear-btn" type="button" popovertarget="departmentLookupPopover" popovertargetaction="hide">Close</button>
          </div>
            <div class="employee-lookup-results-card"> 
                <div class="employee-lookup-results-card-body">
                    <div id="department-lookup-results" class="employee-lookup-results">
                    </div>
                </div>
            </div>
          
        </div>
    </div>
    `;
  // console.log(html);
  document.getElementById("departmentSearch").innerHTML = html;
}
