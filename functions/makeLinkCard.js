function getMode() {
  var mode = localStorage.getItem("bcdash-mode");
  //console.log("Mode is ", mode);
  if (mode == "mode-dark") {
    mod = "dark";
  } else {
    mod = "light";
  }
  return mode;
}
getMode();

function createLinkCard(id, href, icon, text, type, count) {
  const favLinks = JSON.parse(localStorage.getItem("bcdash-favLinks")) || [];
  const isFavorite = favLinks.includes(id);
  var html = `
          <div class="link-card" id=${id}>
          <div class="d-flex items-center">
            <div class="cursor-pointer mr-3 favorite-star" data-href="${href}">
        ${
          isFavorite
            ? '<img src="./icons/star-filled.svg" alt="Favorited" width="24px" />'
            : '<img src="./icons/star-outline.svg" alt="Not Favorited" width="24px" />'
        }
      </div>
            <a href="${href}" target="_blank" referrerpolicy="no-referrer">
              <div class="left">
            

                  <img src="./icons/${icon}-${mod}.svg" alt="${icon} icon" width="32px" />
                  <p>${text}</p>
              </div>
              <div div class="right">
              <img src="./icons/arrow-right-${mod}.svg" alt="right arrrow" width="32px" />
              </div>
              </div>
            </a>
          </div>
      
  `;
  document.getElementById(type + String(count)).innerHTML = html;

  const favoriteStar = document.querySelector(
    `#${type}${count} .favorite-star`
  );
  favoriteStar.addEventListener("click", () => {
    toggleFavorite(id);
    // if (favLinks.includes(id)) {
    //   favoriteStar.innerHTML =
    //     '<img src="./icons/star-filled.svg" alt="Favorited" width="24px" />';
    // } else {
    //   favoriteStar.innerHTML =
    //     '<img src="./icons/star-outline.svg" alt="Not Favorited" width="24px" />';
    // }
    favoriteStar.innerHTML = isFavorite
      ? '<img src="./icons/star-outline.svg" alt="Not Favorited" width="24px" />'
      : '<img src="./icons/star-filled.svg" alt="Favorited" width="24px" />';
  });
}

// when removing on item the entire array is wiped out in local storage, not just the one link that was removed

function toggleFavorite(id) {
  const favLinks = JSON.parse(localStorage.getItem("bc-quicklinks")) || [];

  if (favLinks.includes(id)) {
    // Remove the link from local storage
    const updatedLinks = favLinks.filter((link) => link !== id);
    localStorage.setItem("bc-quicklinks", JSON.stringify(updatedLinks));
  } else {
    // Add the link to local storage
    localStorage.setItem("bc-quicklinks", JSON.stringify([...favLinks, id]));
  }
}
