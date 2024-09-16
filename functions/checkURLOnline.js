async function isSiteOnline(url) {
  try {
    const response = await fetch(url, { mode: "no-cors" });
    console.log("Fetching", url, "with status", response.status);
    return response.status === 200 || response.status === 0;
  } catch (error) {
    console.error("Error fetching", url, ":", error);
    return false;
  }
}
let siteList = [
  {
    href: "https://berkeleycountysc.gov/",
    //   icon: "employee",
    text: "Berkeley County Website",
  },
  {
    href: "https://sheriff.berkeleycountysc.gov/",
    //   icon: "time-clock",
    text: "Berkeley County Sheriff",
  },
  {
    href: "https://agendas.berkeleycountysc.gov/meeting_list.php",
    //   icon: "tshirt",
    text: "Agendas",
  },
  {
    href: "https://gis.berkeleycountysc.gov/",
    //   icon: "jobs",
    text: "GIS",
  },
  {
    href: "https://theunhealthyvegans.com/",
    //   icon: "jobs",
    text: "Fake Site to test fail",
  },
];

async function makeWebsiteStatusCards() {
  const html = await Promise.all(
    siteList.map(async (site) => {
      const { href, text } = site;
      const status = (await isSiteOnline(href)) ? "Online" : "Offline";

      return `
      <a href="${href}" target="_blank" referrerpolicy="no-referrer">
        <div class="card site-card w-100 ${status}">
          <div class="component-text">${text} - ${status}
            <img src="./icons/${status}.svg" alt="status" width="24px" height="24px" class="dress-right"/>
          </div>
        </div>
      </a>
    `;
    })
  );

  document.getElementById("urlStatus").innerHTML = html.join("");
}
