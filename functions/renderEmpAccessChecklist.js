// var data = [
//   {
//     name: "account_request_internet",
//     id: "account_request_internt",
//     title: "Internet",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_mayan",
//     id: "account_request_mayan",
//     title: "Mayan",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_as400",
//     id: "account_request_as400",
//     title: "AS400",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_cogsdale",
//     id: "account_request_cogsdale",
//     title: "Cogsdale / Dynamics",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_timesheet_approver",
//     id: "account_request_timesheet_approver",
//     title: "Timesheet Approver",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_leave_approver",
//     id: "account_request_leave_approver",
//     title: "Leave Approver",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_assessment_utils",
//     id: "account_request_assessment_utils",
//     title: "Assessment Utils",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_network",
//     id: "account_request_network",
//     title: "Network (Required for email)",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_assesspro",
//     id: "account_request_assesspro",
//     title: " AssessPro",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_cms",
//     id: "account_request_cms",
//     title: "CMS",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_energov",
//     id: "account_request_energov",
//     title: "Energov",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_evidence",
//     id: "account_request_evidence",
//     title: "Evidence Manager",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_joint_plan_review",
//     id: "account_request_joint_plan_review",
//     title: "Joint Plan Review",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_finance_enterprise",
//     id: "account_request_finance_enterprise",
//     title: "Finance Enterprise",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_road_manager",
//     id: "account_request_road_manager",
//     title: "Road Manager",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_city_works",
//     id: "account_request_city_works",
//     title: "City Works",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_eam",
//     id: "account_request_eam",
//     title: "EAM",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_bill_trust",
//     id: "account_request_bill_trust",
//     title: "Bill Trust",
//     type: "checkbox",
//   },
//   {
//     name: "account_request_analytics",
//     id: "account_request_analytics",
//     title: "Analytics",
//     type: "checkbox",
//   },
// ];

function generateAccessChecklist(id) {
  // console.log("id");
  // console.log(id);
  fetch("./API/getFeaturesAccessList.php")
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      var html =
        "<ul class='access-rights-checklist' id='access-rights-checklist'>";
      for (var i = 0; i < data.length; i++) {
        html += `<li> 
        <label for="${data[i].id}"> 
          <input type="checkbox" name="${data[i].sNameAndAccess}" id="${
          data[i].id
        }" value="${data[i].id}" />
          ${removeLoDash(data[i].sNameAndAccess)} 
        </label>
        </li>`;
      }

      html += "</ul>";
      html += `<button type="button" class="btn btn-warning btn-sm" onclick="resetChecklist()">Reset Checklist</button>`;
      document.getElementById(id).innerHTML = html;
    });
}

function resetChecklist() {
  try {
    // Select the div by da ID
    const checklistDiv = document.getElementById("access-rights-checklist");

    // Check if the div exists
    if (!checklistDiv) {
      throw new Error("Div with ID 'access-rights-checklist' not found.");
    }

    // Get all checkbox inputs within the div
    const checkboxes = checklistDiv.querySelectorAll('input[type="checkbox"]');

    // Check if there are any checkboxes found
    if (checkboxes.length === 0) {
      console.warn("No checkboxes found within the specified div.");
      return;
    }

    // Set all checkboxes to unchecked
    checkboxes.forEach((checkbox) => {
      checkbox.checked = false;
    });

    console.log("All checkboxes have been unchecked successfully.");
  } catch (error) {
    console.error(
      "An error occurred while unchecking checkboxes:",
      error.message
    );
  }
}
