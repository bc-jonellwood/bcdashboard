function lookupByPhone() {
  var phone = document.getElementById("phone").value;
  // console.log(phone);
  fetch("./API/getSingleEmployeeByPhone.php?phoneNumber=" + phone)
    .then((response) => response.json())
    .then((data) => {
      //console.log(data);
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
          ].sLastName.toLowerCase()}</p>
                            <p class="employee-card-department">${
                              data[i].sDepartmentName
                                ? data[i].sDepartmentName
                                : "None"
                            }</p>
                            <p class="employee-card-phone">${
                              data[i].sMainPhoneNumber
                                ? data[i].sMainPhoneNumber
                                : "None"
                            }</p>
                        </div>
                    </div>
                `;
        }
        document.getElementById("phone-lookup-results").innerHTML = html;
      } else {
        document.getElementById("phone-lookup-results").innerHTML =
          "No results found.";
      }
    });
}

function renderPhoneLookup() {
  var html = `
    <div class="phone-lookup">
        <div class="phone-lookup-body">
            <div class="phone-lookup-card">
                <div class="phone-lookup-card-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control phone-lookup-input" id="phone" placeholder="Phone Number">
                        <button class="btn btn-success" type="button" id="button-addon2" onclick="lookupByPhone()">Search</button>
                    </div>
                </div>
            </div>
            <div class="phone-lookup-results-card">
                <div class="phone-lookup-results-card-body">
                    <div id="phone-lookup-results" class="phone-lookup-results">
                    </div>
                </div>
            </div>
            <div class="popover-btn-holder">
                <button class="btn btn-secondary btn-small phone-lookup-clear-btn" type="button" onclick="clearPhoneLookup()">Clear</button>
                <button class="btn btn-danger btn-small phone-lookup-clear-btn" type="button" popovertarget="phoneLookupPopover" popovertargetaction="hide">Close</button>
            </div>
        </div>
    </div>
    `;
  document.getElementById("phoneSearch").innerHTML = html;

  maskInput();
}

function maskInput() {
  const element = document.getElementById("phone");
  const maskOptions = {
    mask: "000-000-0000",
  };
  const mask = new IMask(element, maskOptions);
}

function clearPhoneLookup() {
  document.getElementById("phone-lookup-results").innerHTML = "";
  document.getElementById("phone").value = "";
}
