function renderTimeApproverSelectElement(id) {
  if (id == "newUserTimeApprover") {
    aid = "1023";
  } else if (id == "newUserLeaveApprover") {
    aid = "1024";
  }
  fetch("./API/getTimeApprovers.php?sFeatureAccessId=" + aid)
    .then((response) => response.json())
    .then((data) => {
      var html = "<option value=''>Select Approver</option>";
      for (var i = 0; i < data.length; i++) {
        html += `<option value="${data[i].sUserId}">${data[i].empName}</option>`;
      }
      document.getElementById(id).innerHTML = html;
    });
}
