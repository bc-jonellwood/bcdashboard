function generateAccessChecklist(id) {
  // console.log("id");
  // console.log(id);
  fetch("./API/getFeaturesAccessList.php")
    .then((response) => response.json())
    .then((data) => {
      console.log("features access list");
      console.log(data);
      var internal = data[0].internal;
      console.log("internal");
      console.log(internal);
      var external = data[1].external;
      var html = `
      <span>My Berkeley Applications</span>
      <ul class='access-rights-checklist' id='internal-access-rights-checklist'>`;
      for (var i = 0; i < internal.length; i++) {
        html += `<li> 
        <label for="${internal[i].id}"> 
          <input type="checkbox" name="${internal[i].sNameAndAccess}" id="${
          internal[i].id
        }" value="${internal[i].id}" /> ${removeLoDash(
          internal[i].sNameAndAccess
        )}</label>
        </li>`;
      }

      html += "</ul>";
      html += "<span>Other Applications and Access</span>";
      html +=
        "<ul class='access-rights-checklist' id='external-access-rights-checklist'>";

      for (var j = 0; j < external.length; j++) {
        html += `<li> 
        <label for="${external[j].id}"> 
          <input type="checkbox" name="${external[j].sNameAndAccess}" id="${
          external[j].id
        }" value="${external[j].id}" /> ${removeLoDash(
          external[j].sNameAndAccess
        )}</label>
        </li>`;
      }
      html += `</ul><button type="button" class="btn btn-warning btn-sm" onclick="resetChecklist()">Reset Checklist</button>`;
      document.getElementById(id).innerHTML = html;
    });
}

function resetChecklist() {
  try {
    // Select the div by da ID
    const ichecklistDiv = document.getElementById(
      "internal-access-rights-checklist"
    );
    const echecklistDiv = document.getElementById(
      "external-access-rights-checklist"
    );

    // Check if the div exists
    if (!ichecklistDiv) {
      throw new Error(
        "Div with ID 'internal-access-rights-checklist' not found."
      );
    }
    if (!echecklistDiv) {
      throw new Error(
        "Div with ID 'ecternal-access-rights-checklist' not found."
      );
    }

    // Get all checkbox inputs within the div
    const icheckboxes = ichecklistDiv.querySelectorAll(
      'input[type="checkbox"]'
    );
    const echeckboxes = echecklistDiv.querySelectorAll(
      'input[type="checkbox"]'
    );
    // Check if there are any checkboxes found
    if (icheckboxes.length === 0) {
      console.warn("No checkboxes found within the specified div.");
      return;
    }

    if (echeckboxes.length === 0) {
      console.warn("No checkboxes found within the specified div.");
      return;
    }

    // Set all checkboxes to unchecked
    icheckboxes.forEach((checkbox) => {
      checkbox.checked = false;
    });

    echeckboxes.forEach((checkbox) => {
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
