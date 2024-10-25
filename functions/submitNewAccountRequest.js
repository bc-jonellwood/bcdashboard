// Function to get th checked checkbox IDs from the access rights checklist
function getCheckedAccessRights() {
  // Init empty array to hold the IDs of checked checkboxes
  const accessRights = [];

  try {
    // Select the ul element by its ID
    // const checklist = document.getElementById("access-rights-checklist");
    var employeeAccessRights = document.getElementById("employeeAccessRights");
    // var checklist = employeeAccessRights.querySelectorAll('input[type="checkbox"]');
    // Check if the checklist exists
    // if (!checklist) {
    //   throw new Error("Checklist element not found.");
    // }

    // Get all the checkbox inputs within the ul element
    const checkboxes = employeeAccessRights.querySelectorAll(
      'input[type="checkbox"]'
    );

    // loop the checks to check if it is checked. check?
    checkboxes.forEach((checkbox) => {
      if (checkbox.checked) {
        // Push the ID of the checked checkbox into the accessRights array
        accessRights.push({ [checkbox.id]: checkbox.id });
      }
    });
  } catch (error) {
    // Log the err
    console.error(
      "An error occurred while retrieving access rights:",
      error.message
    );
  }

  // Return the array of checked checkbox IDs
  return accessRights;
}

function submitNewAccountRequest() {
  // init empty array to hold the values we gonna send that backend
  var formData = [];
  // reset the error message if present
  const errorHolder = document.getElementById("errorMessage");
  errorHolder.innerHTML = "";
  errorHolder.classList.remove("activeError");
  const newRequestEmpNumber = document.getElementById(
    "newUserRequestEmployeeNumber"
  ).textContent;
  const userId = document.getElementById("newUserId").value;
  const timeApprover = document.getElementById("newUserTimeApprover").value;
  const leaveApprover = document.getElementById("newUserLeaveApprover").value;
  const setupEq = document.getElementById("setupEquivalent").value;
  // const compAssetNumber = document.getElementById("computerAssetNumber").value;
  const deskPhone = document.getElementById("deskPhone").value;
  const emailType = document.getElementById("emailType").value;
  const officeApplicationType = document.getElementById(
    "officeApplicationType"
  ).value;
  const accessRightsList = getCheckedAccessRights();
  const requestComments = document.getElementById(
    "newUserRequestComments"
  ).value;

  var errormessage = "";
  if (timeApprover == "" || leaveApprover == "") {
    errormessage += "<p>Please select an approver.<p/>";
  }
  if (!setupEq) {
    errormessage += "<p>Please select a setup equivalent</p>";
  }

  if (errormessage == "") {
    // console.log("No errors");
    newRequestEmpNumber
      ? formData.push({ newRequestEmpNumber: newRequestEmpNumber })
      : "";
    timeApprover ? formData.push({ timeApprover: timeApprover }) : "";
    leaveApprover ? formData.push({ leaveApprover: leaveApprover }) : "";
    // compAssetNumber
    //   ? formData.push({ compAssetNumber: compAssetNumber })
    //   : formData.push({ compAssetNumber: "None" });
    deskPhone
      ? formData.push({ deskPhone: deskPhone })
      : formData.push({ deskPhone: "None" });
    formData.push({ emailType: emailType });
    formData.push({
      officeApplicationType: officeApplicationType,
    });
    if (accessRightsList.length > 0) {
      formData.push({ accessRightsList: accessRightsList });
    } else {
      formData.push({ accessRightsList: "None" });
    }
    requestComments
      ? formData.push({ requestComments: requestComments })
      : formData.push({ requestComments: "None" });
    formData.push({ requestType: "new_returning_user" });
    userId
      ? formData.push({ newRequestUserId: userId })
      : formData.push({ newRequestUserId: "None" });
    // document.getElementById("newUserRequestForm").submit();
    fetch("./API/addAccountRequest.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(formData),
    })
      .then((response) => response.json())
      .then((data) => console.log(data))
      .catch((error) => console.error(error))
      .then((error) => {
        errorHolder.innerHML = `<p>${error}</p>`;
        errorHolder.classList.add("activeError");
      });
  } else {
    errorHolder.innerHTML = errormessage;
    errorHolder.classList.add("activeError");
  }
}
