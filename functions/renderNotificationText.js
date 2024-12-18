// function to fetch data from API/getCurrentNotifications.php and render it to the screen as well as store it in local storage.

class notification {
  constructor() {
    this.storageKey = "bcdash-notification-text";
  }

  async fetchNotification() {
    const response = await fetch("/API/getCurrentNotification.php");
    const data = await response.json();
    return data;
  }

  async saveToLocalStorage(data) {
    const expires = new Date(data[0].dtEndDate).getTime();
    const notificationData = {
      text: data[0].sNotificationText,
      start: data[0].dtStartDate,
      end: data[0].dtEndDate,
      expires: expires,
    };
    localStorage.setItem(this.storageKey, JSON.stringify(notificationData));
  }

  async getFromLocalStorage() {
    const storedData = localStorage.getItem(this.storageKey);
    if (storedData) {
      const data = JSON.parse(storedData);
      const now = new Date().getTime();
      if (data.expires > now) {
        // remove expired data
        localStorage.removeItem(this.storageKey);
        return null;
      }
      return data;
    }
    return null;
  }

  async renderNotifcationText() {
    const storedData = await this.getFromLocalStorage();
    if (!storedData) {
      const data = await this.fetchNotification();
      await this.saveToLocalStorage(data);
      return data;
    }
    return storedData;
  }
}
