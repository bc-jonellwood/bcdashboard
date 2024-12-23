function createLinkCard(id, href, icon, text, type, count) {
  const favLinks = JSON.parse(localStorage.getItem("bc-quicklinks")) || [];
  const isFavorite = favLinks.includes(id);
  var target = document.getElementById(type);
  var html = `
          <div class="link-card">
            <div class="d-flex items-center justify-between">
             
            <input class="favorite-star" type="checkbox" id="${id}" value="${id}" ${
    isFavorite ? "checked" : ""
  } /> 
              <label for="${id}" class="star-label">
                ${isFavorite ? "&#9733;" : "&#9733;"}
              </label>
              <a href="${href}" target="_blank" referrerpolicy="no-referrer" class="left w-100">
                  <div class="left">
                    <img src="../images/${icon}-dark.svg" alt="${icon} icon" width="24px" />
                    <p>${text}</p>
                  </div>
                  <div div class="right">
                    <img src="../images/arrow-right-dark.svg" alt="right arrrow" width="24px" />
                  </div>
              </a>
            </div>
          </div>
  `;

  target.insertAdjacentHTML("beforeend", html);

  // const favoriteStar = document.querySelector(
  //   `#${type}${count} .favorite-star`
  // );
  // favoriteStar.addEventListener("click", () => {
  //   toggleFavorite(id);
  // });
  const favoriteCheckbox = document.getElementById(id);
  // console.log("fav checkbox", favoriteCheckbox);
  favoriteCheckbox.addEventListener("change", () => {
    toggleFavorite(id);
  });
}
// function createElementFromHTML(htmlString) {
//   var div = document.createElement("div");
//   div.innerHTML = htmlString.trim();
//   return div.firstChild;
// }
// when removing on item the entire array is wiped out in local storage, not just the one link that was removed

function toggleFavorite(id) {
  // console.log("toggling favorite for ", id);
  const favLinks = JSON.parse(localStorage.getItem("bc-quicklinks")) || [];
  // const favoriteStar = document.getElementById(id);

  if (favLinks.includes(id)) {
    // Remove the link from local storage
    const updatedLinks = favLinks.filter((link) => link !== id);
    localStorage.setItem("bc-quicklinks", JSON.stringify(updatedLinks));
    // favoriteStar.innerHTML =
    //   '<img src="./images/star-outline.svg" alt="Not Favorited" width="24px" />';
  } else {
    // Add the link to local storage
    localStorage.setItem("bc-quicklinks", JSON.stringify([...favLinks, id]));
    // favoriteStar.innerHTML =
    //   '<img src="./images/star-filled.svg" alt="Favorited" width="24px" />';
  }
}
