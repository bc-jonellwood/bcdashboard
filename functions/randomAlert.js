function getRandomAlertMessage() {
	const alertMessages = [
		'Reminder: Quarterly budget reports are due by the end of the week.',
		"Alert: Scheduled maintenance on the county's network will occur tonight from 10pm-2am.",
		'Notice: The county commission meeting has been rescheduled for next Thursday at 2pm.',
		'Warning: A severe weather alert has been issued for our area, please check local news for updates.',
		"Reminder: The county's annual employee appreciation event is next Friday at 12pm.",
		'Alert: A cybersecurity threat has been detected, please be cautious when opening emails and attachments.',
	];

	return alertMessages[Math.floor(Math.random() * alertMessages.length)];
}

// console.log(getRandomAlertMessage());
