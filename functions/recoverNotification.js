async function recoverNotification(id) {
  const target = document.getElementById(id);
  target.classList.remove("inactive");
  updateButtonText(id, "active");
  const response = await fetch("./API/recoverNotification.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `id=${id}`,
  });
}
