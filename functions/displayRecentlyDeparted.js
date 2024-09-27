// function formatDate(str) {
// 	const date = new Date(str);
// 	const day = date.getDate();
// 	const month = date.getMonth() + 1;
// 	const year = date.getFullYear();
// 	return `${day}/${month}/${year}`;
// }

async function theDeparted() {
  await fetch("./API/getSeparatedEmps.php")
    .then((response) => response.json())
    .then((data) => {
      //console.log(data);
      let html = `<table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Separated Date</th>
                            <th>Updated</th>
                        </tr>
            `;
      for (var i = 0; i < data.length; i++) {
        html += `
                <tr class="emp-card">
			        <td class="name">${data[i].empName.toLowerCase()}</td>
			        <td class="name">${data[i].deptName.toLowerCase()}</td>
			        <td>${formatDate(data[i].seperation_date)}</td>
			        <td>${formatDate(data[i].updated)}</td>
			    </tr>
			`;
      }

      html += "</table>";
      document.getElementById("recentSeparationsContent").innerHTML = html;
    })
    .catch((error) => {
      console.log(error);
    });
}
