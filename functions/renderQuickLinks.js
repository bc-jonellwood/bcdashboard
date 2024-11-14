const cacheKey = "bc-linkDatCache";
const favoriteKey = "bc-quickLinks";
const cacheExpiryHours = 24;

async function loadLinks() {
  const cachedData = JSON.parse(localStorage.getItem(cacheKey));
  const now = new Date();
  console.log("now", now);
  if (
    cachedData &&
    now - new Date(cachedData.timestamp) < cacheExpiryHours * 60 * 60 * 1000
  ) {
    renderLinks(cachedData.links);
  } else {
    await fetch("./API/getLinkData.php")
      .then(console.log("fetching data nothing cached"))
      .then((response) => response.json())
      .then((data) => {
        localStorage.setItem(
          cacheKey,
          JSON.stringify({ links: data, timestamp: now })
        );
        renderLinks(data);
      });
  }
}

function renderLinks(data) {
  console.log(data);
  var html = `
      <div id="quickLinks">
        <ul class="list-group list-group-flush no-list-style small">`;
  for (var i = 0; i < data.length; i++) {
    html += `<li>${data[i].sText}</li>`;
  }
  `
        </ul>
      </div>
    `;
  document.getElementById("quickLinksMenu").innerHTML = html;
}
// renderQuickLinks(data);
