// const cacheKey = "bc-linkDatCache";
// const favoriteKey = "bc-quickLinks";
// const cacheExpiryHours = 24;

// async function loadLinks() {
//   const cachedData = JSON.parse(localStorage.getItem(cacheKey));
//   const now = new Date();
//   console.log("now", now);
//   if (
//     cachedData &&
//     now - new Date(cachedData.timestamp) < cacheExpiryHours * 60 * 60 * 1000
//   ) {
//     renderLinks(cachedData.links);
//   } else {
//     await fetch("./API/getLinkData.php")
//       .then(console.log("fetching data nothing cached"))
//       .then((response) => response.json())
//       .then((data) => {
//         localStorage.setItem(
//           cacheKey,
//           JSON.stringify({ links: data, timestamp: now })
//         );
//         renderLinks(data);
//       });
//   }
// }

const cacheKey = "bc-linkDatCache";
const favoriteKey = "bc-quicklinks";
const cacheExpiryHours = 24;

async function loadLinks() {
  const cachedData = JSON.parse(localStorage.getItem(cacheKey));
  const quickLinks = JSON.parse(localStorage.getItem(favoriteKey)) || [];
  const now = new Date();

  if (
    cachedData &&
    now - new Date(cachedData.timestamp) < cacheExpiryHours * 60 * 60 * 1000
  ) {
    // Reorder links so quickLinks appear at the top
    const orderedLinks = prioritizeQuickLinks(cachedData.links, quickLinks);
    // console.log("orderedLinks");
    // console.log(orderedLinks);
    renderLinks(orderedLinks);
  } else {
    console.log("fetching data, nothing cached");
    await fetch("./API/getLinkData.php")
      .then((response) => response.json())
      .then((data) => {
        localStorage.setItem(
          cacheKey,
          JSON.stringify({ links: data, timestamp: now })
        );
        const orderedLinks = prioritizeQuickLinks(data, quickLinks);
        console.log("orderedLinks");
        console.log(orderedLinks);
        renderLinks(orderedLinks);
      });
  }
}

// Function to prioritize quick links in the list
function prioritizeQuickLinks(links, quickLinks) {
  // console.log("quickLinks");
  // console.log(quickLinks);
  // console.log("links");
  // console.log(links);

  const quickLinksSet = new Set(quickLinks);

  // Filter and move quick links to the top
  const favoriteLinks = links.filter((link) => quickLinksSet.has(link.sLinkId));
  console.log("favoriteLinks");
  console.log(favoriteLinks);
  const otherLinks = links.filter((link) => !quickLinksSet.has(link.sLinkId));
  console.log("otherLinks");
  console.log(otherLinks);
  return [...favoriteLinks, ...otherLinks];
  // renderLinks([...favoriteLinks, ...otherLinks]);
}

function renderLinks(data) {
  // console.log(data);
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
