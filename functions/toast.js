function toast(title, message, type) {
  var toastTitleElement = document.getElementById("toast-popover-title");
  var toastMessageElement = document.getElementById("toast-message");
  var toastHeader = document.getElementById("toast-popover-title");
  var toastEl = document.getElementById("toast-popover");

  toastTitleElement.textContent = title;
  toastMessageElement.textContent = message;
  toastHeader.classList.add(type);
  toastEl.classList.add(type);
}
