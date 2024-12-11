// async function fetchCardData() {
//   await fetch("./API/getCardDataFromDatabase.php")
//     .then((response) => response.json())
//     .then((data) => {
//       console.log(data);
//       localStorage.setItem("bcdash-cardData", JSON.stringify(data));
//     });
// }

async function fetchCardData() {
  await fetch("./API/getCardDataFromDatabase.php")
    .then((response) => response.json())
    .then((data) => {
      //console.log(data);

      let localStorageData =
        JSON.parse(localStorage.getItem("bcdash-cardData")) || [];
      if (localStorageData.length === 0) {
        localStorage.setItem("bcdash-cardData", JSON.stringify(data));
      } else {
        let maxOrder = Math.max(
          ...localStorageData.map((card) => card.sCardOrder),
          0
        );
        data.forEach((card) => {
          if (!localStorageData.some((localCard) => localCard.id === card.id)) {
            card.sCardOrder = ++maxOrder;
            localStorageData.push(card);
          }
        });
        localStorage.setItem(
          "bcdash-cardData",
          JSON.stringify(localStorageData)
        );
      }
    });
}
