function renderHideCardList() {
  const form = document.createElement("form");
  form.action = "/API/markCardsAsHidden.php";
  form.method = "POST";

  var cards = localStorage.getItem("bcdash-cardData");
  cards = JSON.parse(cards);
  cards = cards.sort((a, b) => a.sCardOrder - b.sCardOrder);

  cards.forEach((card, index) => {
    const cardDiv = document.createElement("div");
    cardDiv.className = "card-hide-list-item";
    const checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    checkbox.name = `cards[${card.sCardId}]`;
    checkbox.checked = card.bIsVisible;
    checkbox.value = card.bIsVisible ? "1" : "0";
    checkbox.addEventListener("change", (e) => {
      checkbox.value = e.target.checked ? "1" : "0";
    });
    const label = document.createElement("label");
    label.textContent = card.sCardName;
    label.htmlFor = `cards[${card.sCardId}]`;

    cardDiv.appendChild(label);
    label.appendChild(checkbox);
    form.appendChild(cardDiv);
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      form.submit();
    });
  });

  const saveButton = document.createElement("button");
  saveButton.type = "button";
  saveButton.className = "btn btn-primary order-save-btn";
  saveButton.textContent = "Save";
  saveButton.addEventListener("click", () => {
    updateLocalStorageVisibility();
  });
  form.appendChild(saveButton);
  document.getElementById("cardHideList").appendChild(form);
}
// function updateLocalStorageVisibility() {
//   const cards = document.querySelectorAll(".card-hide-list-item");
//   const cardData = JSON.parse(localStorage.getItem("bcdash-cardData"));

//   const cardEntry = cardData.find((c) => c.sCardId === cardId);
//   if(cardEntry){
//     cardEntry.bIsVisible = checkbox.checked ? "1" : "0";
//   }
// }
function updateLocalStorageVisibility() {
  // Get the list of card elements
  const cards = document.querySelectorAll(".card-hide-list-item");

  // Parse the current local storage data
  const cardData = JSON.parse(localStorage.getItem("bcdash-cardData"));

  // Map through each card element
  cards.forEach((card) => {
    // Extract the card ID from the checkbox name
    const checkbox = card.querySelector("input[type='checkbox']");
    const cardId = checkbox.name.match(/\[(.*?)\]/)[1]; // Extract the sCardId from cards[sCardId]

    // Find the corresponding card entry in local storage data
    const cardEntry = cardData.find((c) => c.sCardId === cardId);
    if (cardEntry) {
      // Update the visibility value based on the checkbox state
      cardEntry.bIsVisible = checkbox.checked ? "1" : "0";
    }
  });

  // Save the updated card data back to local storage
  localStorage.setItem("bcdash-cardData", JSON.stringify(cardData));
}
