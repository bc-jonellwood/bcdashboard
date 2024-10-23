function lookupEmployee() {
  const firstName = document.getElementById("employee-lookup-first-name").value;
  const lastName = document.getElementById("employee-lookup-last-name").value;
  //   console.log(name);
  fetch("./API/getSingleEmployee.php?name=" + firstName + " " + lastName)
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
                                <p class="employee-card-department">${
                                  data[i].sDepartmentName
                                } </p>
                                <p class="employee-card-phone">${
                                  data[i].sMainPhoneNumber
                                }</p>
                            </div>  
                        </div>
                    `;
        }
        document.getElementById("employee-lookup-results").innerHTML = html;
      } else {
        document.getElementById("employee-lookup-results").innerHTML =
          "No results found";
      }
    })
    .catch((error) => {
      console.log(error);
    });
}

function clearEmployeeLookup() {
  document.getElementById("employee-lookup-first-name").value = "";
  document.getElementById("employee-lookup-last-name").value = "";
  document.getElementById("employee-lookup-results").innerHTML = "";
}

function renderEmployeeLookup() {
  var html = `
    <div class="employee-lookup">
        <div class="employee-lookup-body">
            <div class="employee-lookup-card">
                <div class="employee-lookup-card-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control employee-lookup-input" id="employee-lookup-first-name" placeholder="First Name">
                        <input type="text" class="form-control employee-lookup-input" id="employee-lookup-last-name" placeholder="Last Name">
                         <button class="btn btn-success" type="button" id="button-addon2" onclick="lookupEmployee()">Search</button>
                    </div>
                </div>
            </div>
            <div class="employee-lookup-results-card"> 
                <div class="employee-lookup-results-card-body">
                    <div id="employee-lookup-results" class="employee-lookup-results">
                    </div>
                </div>
            </div>
          <div class="popover-btn-holder">
            <button class="btn btn-secondary btn-small employee-lookup-clear-btn" type="button" onclick="clearEmployeeLookup()">Clear</button>
            <button class="btn btn-danger btn-small employee-lookup-clear-btn" type="button" popovertarget="employeeLookupPopover" popovertargetaction="hide">Close</button>
            </div>
        </div>
    </div>
    `;
  // console.log(html);
  document.getElementById("employeeSearch").innerHTML = html;
}
