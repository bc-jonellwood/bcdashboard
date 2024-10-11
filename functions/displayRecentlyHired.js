// function formatDate(str) {
// 	const date = new Date(str);
// 	const day = date.getDate();
// 	const month = date.getMonth() + 1;
// 	const year = date.getFullYear();
// 	return `${day}/${month}/${year}`;
// }

async function theNewbies() {
  await fetch("./API/getNewEmps.php")
    .then((response) => response.json())
    .then((data) => {
      //console.log(data);
      let html = `<table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Start Date</th>
                    
                        </tr>
            `;
      for (var i = 0; i < data.length; i++) {
        var empName = data[i].sFirstName + " " + data[i].sLastName;
        html += `
                <tr class="emp-card">
			        <td class="name">${empName.toLowerCase()}</td>
			        <td class="name">${data[i].sDepartmentName.toLowerCase()}</td>
			        <td>${formatDate(data[i].dtStartDate)}</td>
			    </tr>
			`;
      }

      html += "</table>";
      document.getElementById("recentHiredContent").innerHTML = html;
    })
    .catch((error) => {
      console.log(error);
    });
}
