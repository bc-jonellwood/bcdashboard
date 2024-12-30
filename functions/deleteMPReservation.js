async function deleteMPReservation(id) {
  var row = document.getElementById(id);
  if (window.confirm("Are you sure you want to cancel this reservation?")) {
    await fetch("/API/mpCancelReservation.php?id=" + id)
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          row.remove();
          alert("Reservation " + id + " has been cancelled.");
        } else {
          alert("Failed to cancel reservation.");
        }
      });
    // row.remove();
  }
  //   alert("Reservation " + id + " has been deleted.");
}
