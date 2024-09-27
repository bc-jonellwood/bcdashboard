async function getNotifications() {
  var html = "";
  try {
    const response = await fetch("./API/getNotifications.php");
    const data = await response.json();
    // renderCalendar(data);
    renderAgenda(data);
    // var i = 0;
    // html += `<table class="table">
    //         <tr>
    //             <th>Notification</th>
    //             <th>Updated</th>
    //         </tr>
    //     `;
    // for (var i = 0; i < data.length; i++) {
    //   console.log("IN the loop");
    //   console.log(data[i].id);
    //   html += `
    //         <tr>
    //             <td class="name">${data[i].id}</td>
    //             <td>${data[i].sNotificationText}</td>
    //         </tr>
    //         `;
    //   i++;
    // }

    // console.log(html);
    // html += "</table>";
    // document.getElementById("recentNotificationsContent").innerHTML = html;
  } catch (error) {
    console.log(error);
  }
}

// getNotifications();
