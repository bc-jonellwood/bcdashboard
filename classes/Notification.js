// function to fetch data from API/getCurrentNotifications.php and render it to the screen as well as store it in local storage.

class Notification {
  constructor() {
    this.storageKey = "bcdash-notification-text";
  }

  async fetchNotification() {
    console.log("Fetching Notification from Database");
    const response = await fetch("./API/getCurrentNotification.php");
    const data = await response.json();
    return data;
  }

  async saveToLocalStorage(data) {
    const expires = new Date(data[0].dtEndDate).getTime();
    const notificationData = {
      text: data[0].sNotificationText,
      start: data[0].dtStartDate,
      end: data[0].dtEndDate,
      type: data[0].sNotificationType,
      expires: expires,
    };
    localStorage.setItem(this.storageKey, JSON.stringify(notificationData));
    setAlert();
  }

  async getFromLocalStorage() {
    const storedData = localStorage.getItem(this.storageKey);
    console.log("Stored Data:", storedData);
    if (storedData) {
      const data = JSON.parse(storedData);
      const now = new Date().getTime();
      if (!data.expires > now) {
        // remove expired data
        console.log("Removing expired data");
        localStorage.removeItem(this.storageKey);
        return null;
      }
      console.log("Returning Stored Data:", data);
      return data;
    }

    console.log("No Stored Data");
    return null;
  }

  async renderNotifcationText() {
    const storedData = await this.getFromLocalStorage();
    //console.log("Stored Data:", storedData);
    if (!storedData) {
      const data = await this.fetchNotification();
      await this.saveToLocalStorage(data);
      // return data;
    }

    return storedData;
  }
}
