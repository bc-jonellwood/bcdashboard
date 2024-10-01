function createSessions(
  eventStartTime,
  sessionLength,
  maxAttendees,
  eventDuration
) {
  // Validate input parameters
  try {
    // Convert input parameters to appropriate types
    const startTime = parseTime(eventStartTime);
    const lengthInMinutes = parseInt(sessionLength, 10);
    const maxAttendeesCount = parseInt(maxAttendees, 10);
    const durationInHours = parseInt(eventDuration, 10);

    // Check for valid input values
    if (
      isNaN(startTime) ||
      isNaN(lengthInMinutes) ||
      isNaN(maxAttendeesCount) ||
      isNaN(durationInHours)
    ) {
      throw new Error(
        "Invalid input: Please ensure all inputs are valid numbers."
      );
    }

    if (
      lengthInMinutes <= 0 ||
      maxAttendeesCount <= 0 ||
      durationInHours <= 0
    ) {
      throw new Error(
        "Invalid input: Session length, max attendees, and event duration must be greater than zero."
      );
    }

    // Calculate total event duration in minutes
    const totalEventDuration = durationInHours * 60;
    const endTime = startTime + totalEventDuration;

    // Check if sessions can fit within the event duration
    if (startTime + lengthInMinutes > endTime) {
      throw new Error(
        "Error: The session cannot start as it exceeds the event duration."
      );
    }

    const sessions = [];
    for (let i = 0; i < totalEventDuration; i += lengthInMinutes) {
      const sessionStart = startTime + i;
      if (sessionStart + lengthInMinutes <= endTime) {
        sessions.push({
          slot_id: generateGUID(),
          sessionNumber: i,
          startTime: formatTime(sessionStart),
          length: lengthInMinutes,
          maxAttendees: maxAttendeesCount,
        });
      }
    }

    return sessions;
  } catch (error) {
    console.error(error.message);
    return [];
  }
}

// Helper function to parse time in 'HH:mm' format
function parseTime(timeString) {
  const [hours, minutes] = timeString.split(":").map(Number);
  return hours * 60 + minutes; // Convert to total minutes
}

// Helper function to format time back to 'HH:mm'
function formatTime(totalMinutes) {
  const hours = Math.floor(totalMinutes / 60);
  const minutes = totalMinutes % 60;
  return `${String(hours).padStart(2, "0")}:${String(minutes).padStart(
    2,
    "0"
  )}`;
}
function generateGUID() {
  try {
    // Generate a random GUID
    const randomPart = () =>
      Math.floor((1 + Math.random()) * 0x10000)
        .toString(16)
        .substring(1);
    const guid = `${randomPart()}${randomPart()}-${randomPart()}-${randomPart()}-${randomPart()}-${randomPart()}${randomPart()}${randomPart()}`;

    return guid.toUpperCase();
  } catch (error) {
    console.error("An error occurred while generating the GUID:", error);
    return null; // Return null in case of an error
  }
}
