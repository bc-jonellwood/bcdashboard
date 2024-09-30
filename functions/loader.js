function showLoader() {
  var loader = document.getElementById("loader-container-overlay");
  loader.classList.remove("hidden");
}

function hideLoader() {
  var loader = document.getElementById("loader-container-overlay");
  loader.classList.add("hidden");
}
