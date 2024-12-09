function moveCardUp(cardId) {
  console.log("moveCardUp", cardId);
  var cards = localStorage.getItem("bcdash-cardData");
  cards = JSON.parse(cards);
  let cardIndex = cards.findIndex((card) => card.sCardId === cardId);
  cardIndex = parseInt(cardIndex);
  if (cardIndex > 0) {
    let temp = cards[cardIndex];
    cards[cardIndex] = cards[cardIndex - 1];
    cards[cardIndex - 1] = temp;
    cards[cardIndex].sCardOrder = cardIndex;
    cards[cardIndex - 1].sCardOrder = cardIndex - 1;
    localStorage.setItem("bcdash-cardData", JSON.stringify(cards));
    renderCardList();
  }
}

function moveCardDown(cardId) {
  var cards = localStorage.getItem("bcdash-cardData");
  cards = JSON.parse(cards);
  let cardIndex = cards.findIndex((card) => card.sCardId === cardId);
  cardIndex = parseInt(cardIndex);
  if (cardIndex < cards.length - 1) {
    let temp = cards[cardIndex];
    cards[cardIndex] = cards[cardIndex + 1];
    cards[cardIndex + 1] = temp;
    cards[cardIndex].sCardOrder = cardIndex;
    cards[cardIndex + 1].sCardOrder = cardIndex + 1;
    localStorage.setItem("bcdash-cardData", JSON.stringify(cards));
    renderCardList();
  }
}

function renderCardList() {
  var cards = localStorage.getItem("bcdash-cardData");
  cards = JSON.parse(cards);
  cards = cards.sort((a, b) => a.sCardOrder - b.sCardOrder);
  let html = '<table class="table card-list">';
  for (let i = 0; i < cards.length; i++) {
    html += `
        <tr>
        <td data-id="${cards[i].sCardId}" class='card-list-item' style='cardListItem-${i}'>
            <p>${cards[i].sCardName}</p>
            <p>
                <input type="button" class='btn btn-primary btn-sm' value="Up" onclick="moveCardUp('${cards[i].sCardId}')">
            </p>
            <p>
                <input type="button" class='btn btn-primary btn-sm' value="Down" onclick="moveCardDown('${cards[i].sCardId}')">
            </p>
        </td>
        </tr>
    `;
  }
  html += "</table>";

  document.getElementById("cardList").innerHTML = html;
}
