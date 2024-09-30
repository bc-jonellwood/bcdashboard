async function deleteNotification(id) {
  const target = document.getElementById(id);
  target.classList.add("inactive");
  updateButtonText(id, "inactive");

  const response = await fetch("./API/deleteNotification.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `id=${id}`,
  });
}
