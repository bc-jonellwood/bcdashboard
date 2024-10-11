function displayThemeAndMode() {
  var theme = localStorage.getItem("bcdash-theme");
  var mode = localStorage.getItem("bcdash-mode");
  //console.log('theme and mode', theme, mode);
  document.getElementById("theme").innerText = theme;
  document.getElementById("mode").innerText = mode;
}
