function getMode() {
  var mode = localStorage.getItem("bcdash-mode");
  console.log("Mode is ", mode);
  if (mode == "mode-dark") {
    mod = "dark";
  } else {
    mod = "light";
  }
  return mod;
}
getMode();

function createLinkCard(href, icon, text, type, count) {
  var html = `
          <div class="link-card">
            <a href="${href}" target="_blank" referrerpolicy="no-referrer">
              <div class="left">
                  <img src="./icons/${icon}-${mod}.svg" alt="${icon} icon" width="32px" />
                  <p>${text}</p>
              </div>
              <div div class="right">
                <img src="./icons/arrow-right-${mod}.svg" alt="right arrrow" width="32px" />
              </div>
            </a>
          </div>
  `;
  document.getElementById(type + String(count)).innerHTML = html;
}
