async function fetchQuote() {
  await fetch("https://buddha-api.com/api/today?by=buddha", {
    method: "GET",
    mode: "no-cors",
  })
    .then((response) => response.json())
    .then((data) => {
      document.getElementById("quote").innerText = data.text;
    })
    .catch((error) => {
      console.log(error);
    });
}

async function fetchFact() {
  await fetch("https://uselessfacts.jsph.pl/random.json?language=en")
    .then((response) => response.json())
    .then((data) => {
      document.getElementById("fact").innerText = data.text;
    })
    .catch((error) => {
      console.log(error);
    });
}

fetchFact();
// fetchQuote();
