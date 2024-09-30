let notificationDate = [];
let ranges;
function createRange(startDate, endDate) {
  const startDateTime = new Date(`${startDate}`);
  const endDateTime = new Date(`${endDate}`);

  if (endDateTime <= startDateTime) {
    throw new Error("Ending date/time must be after starting date/time");
  }
  return {
    start: startDateTime,
    end: endDateTime,
  };
}

// function checkForOverlap(ranges) {
//   for (let i = 0; i < ranges.length; i++) {
//     const currentRange = ranges[i];

//     for (let j = i + 1; j < ranges.length; j++) {
//       const otherRange = ranges[j];
//       console.log("currentRange.start");
//       console.log(currentRange.start);
//       console.log("otherRange.end");
//       console.log(otherRange.end);
//       // check for that lap
//       if (
//         currentRange.start <= otherRange.end &&
//         otherRange.start <= currentRange.end
//       ) {
//         return true; // We got that lap
//       }
//     }
//   }
//   return false; // no lap
// }

function checkForOverlap(ranges, newRange) {
  for (let i = 0; i < ranges.length; i++) {
    const currentRange = ranges[i];
    if (
      newRange.start <= currentRange.end &&
      currentRange.start <= newRange.end
    ) {
      return true; // We got that lap
    }
  }
  return false; // no lap
}

async function getNotifications() {
  try {
    const response = await fetch("./API/getNotifications.php");
    const data = await response.json();
    // console.log(data);
    renderAgenda(data);
    const ranges = data.map((obj) =>
      createRange(obj.dtStartDate, obj.dtEndDate)
    );
    // Create an array of dates for each object
    // const notificationDates = data.map((item) => {
    //   const startDate = new Date(`${item.dtStartDate}T${item.dtStartTime}`);
    //   console.log("startDate");
    //   console.log(startDate);
    //   const endDate = new Date(`${item.dtEndDate}T${item.dtEndTime}`);
    //   console.log("endDate");
    //   console.log(endDate);
    //   const dates = [];

    //   while (startDate <= endDate) {
    //     // dates.push(startDate.toISOString());
    //     dates.push(startDate);
    //     startDate.setDate(startDate.getDate() + 1);
    //   }

    //   return dates;
    // });
    // console.log("notification Dates");
    // console.log(ranges);
    return ranges;
  } catch (error) {
    console.log(error);
  }
}

async function getNotificationDataNoRender() {
  try {
    const response = await fetch("./API/getNotifications.php");
    const data = await response.json();
    // console.log(data);

    const ranges = data.map((obj) =>
      createRange(obj.dtStartDate, obj.dtEndDate)
    );

    // console.log("ranges b like");
    // console.log(ranges);
    return ranges;
  } catch (error) {
    console.log(error);
  }
}
