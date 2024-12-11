// function moveCardUp(cardId) {
//   console.log("moveCardUp", cardId);
//   var cards = localStorage.getItem("bcdash-cardData");
//   cards = JSON.parse(cards);
//   let cardIndex = cards.findIndex((card) => card.sCardId === cardId);
//   cardIndex = parseInt(cardIndex);
//   if (cardIndex > 0) {
//     let temp = cards[cardIndex];
//     cards[cardIndex] = cards[cardIndex - 1];
//     cards[cardIndex - 1] = temp;
//     cards[cardIndex].sCardOrder = cardIndex;
//     cards[cardIndex - 1].sCardOrder = cardIndex - 1;
//     localStorage.setItem("bcdash-cardData", JSON.stringify(cards));
//     renderCardList();
//   }
// }

// function moveCardDown(cardId) {
//   var cards = localStorage.getItem("bcdash-cardData");
//   cards = JSON.parse(cards);
//   let cardIndex = cards.findIndex((card) => card.sCardId === cardId);
//   cardIndex = parseInt(cardIndex);
//   if (cardIndex < cards.length - 1) {
//     let temp = cards[cardIndex];
//     cards[cardIndex] = cards[cardIndex + 1];
//     cards[cardIndex + 1] = temp;
//     cards[cardIndex].sCardOrder = cardIndex;
//     cards[cardIndex + 1].sCardOrder = cardIndex + 1;
//     localStorage.setItem("bcdash-cardData", JSON.stringify(cards));
//     renderCardList();
//   }
// }

// function checkForLocalStorage() {
//   const cards = localStorage.getItem("bcdash-cardData");
//   if (cards) {
//     renderCardList();
//   } else {
//     fetch("/API/getCardData.php")
//       .then((response) => response.json())
//       .then((data) => {
//         localStorage.setItem("bcdash-cardData", JSON.stringify(data));
//         renderCardList();
//       });
//   }
// }

function renderCardList() {
  const form = document.createElement("form");
  form.action = "/API/setCardOrderInDatabase.php";
  form.method = "POST";

  var cards = localStorage.getItem("bcdash-cardData");
  cards = JSON.parse(cards);
  cards = cards.sort((a, b) => a.sCardOrder - b.sCardOrder);

  cards.forEach((card, index) => {
    const cardDiv = document.createElement("div");
    cardDiv.className = "card-list-item";
    cardDiv.innerHTML = `
      <input type="hidden" name="cards[]" value="${card.sCardId}">
            <span>${card.sCardName}</span>
            <div class="btn-group">
            <button class='btn btn-primary btn-sm' type="button" onclick="moveUp(${index})">Up</button>
            <button class='btn btn-primary btn-sm' type="button" onclick="moveDown(${index})">Down</button>
            </div>
    `;
    form.appendChild(cardDiv);
  });

  const saveButton = document.createElement("button");
  saveButton.type = "submit";
  saveButton.className = "btn btn-primary order-save-btn";
  saveButton.textContent = "Save";
  form.appendChild(saveButton);
  // document.getElementById("cardContainer").appendChild(form);
  document.getElementById("cardList").appendChild(form);
  // document.getElementById("cardList").innerHTML = html;
}

function moveUp(index) {
  const form = document.querySelector("form");
  const cards = form.querySelectorAll(".card-list-item");
  if (index > 0) {
    form.insertBefore(cards[index], cards[index - 1]);
    updateButtonIndices();
    updateLocalStorage();
  }
}

function moveDown(index) {
  const form = document.querySelector("form");
  const cards = form.querySelectorAll(".card-list-item");
  if (index < cards.length - 1) {
    form.insertBefore(cards[index + 1], cards[index]);
    updateButtonIndices();
    updateLocalStorage();
  }
}

function updateButtonIndices() {
  const cards = document.querySelectorAll(".card-list-item");
  cards.forEach((card, index) => {
    card
      .querySelector("button[onclick^='moveUp']")
      .setAttribute("onclick", `moveUp(${index})`);
    card
      .querySelector("button[onclick^='moveDown']")
      .setAttribute("onclick", `moveDown(${index})`);
  });
}

function updateLocalStorage() {
  const cards = document.querySelectorAll(".card-list-item");
  console.log("cards in updateLocalStorage");
  console.log(cards);

  // Parse the existing card data from local storage
  const cardData = JSON.parse(localStorage.getItem("bcdash-cardData"));

  // Map through the cards and update their order
  const updatedCards = Array.from(cards).map((card, index) => {
    const cardId = card.querySelector("input[name='cards[]']").value;

    // Find the card data entry that matches the cardId
    const cardEntry = cardData.find((c) => c.sCardId === cardId);

    // Update the iCardOrder with the current index position
    if (cardEntry) {
      cardEntry.iCardOrder = index;
    }

    return cardEntry;
  });

  // Save the updated card data back to local storage
  localStorage.setItem("bcdash-cardData", JSON.stringify(updatedCards));
}
