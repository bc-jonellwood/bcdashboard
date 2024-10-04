let PhoneOrgList = [];
let filteredContactList = [];
let contactList = [];
function createContactList(data) {
  // loop over data and for each entry if data.sPhoneOrg is not in the data array (called PhoneOrgList), add it, if it is skip and move on to the next one.
  data.forEach((element) => {
    if (PhoneOrgList.includes(element.sPhoneOrg) === false) {
      PhoneOrgList.push(element.sPhoneOrg);
    }
  });
}

function getFirstInitial(name) {
  // get the first letter of the first name
  return name
    .split(" ")
    .slice(0, 1)
    .map((n) => n[0])
    .join("")
    .toUpperCase();
}

function createFilteredContactList(orgName, data) {
  var filteredContactList = [];
  // loop over data and for each entry where sPhoneOrg is equal to orgName, add it to the filteredContactList
  data.forEach((element) => {
    if (element.sPhoneOrg === orgName) {
      filteredContactList.push(element);
    }
  });
  //   console.log(filteredContactList);
  var detailsHtml = "<h3 class='org-name'>" + orgName + "</h3>";
  for (var i = 0; i < filteredContactList.length; i++) {
    detailsHtml += `
        <div class ="contact-card">
            <p class="contact-card-contact-name">${filteredContactList[i].sPhoneName}</p>
            <div class="contact-card-details">
                <p class="mb-1 d-flex">
                    <img class="type-icon" src="./icons/${filteredContactList[i].sPhoneType}.svg" alt="icon" />
                    ${filteredContactList[i].sPhoneType}
                </p>
                <p class="mb-1">${filteredContactList[i].sPhoneNumber}</p>
            </div>
        </div>
        `;
  }

  document.getElementById("contact-details").innerHTML = detailsHtml;
}

function renderContactList(data) {
  contactList = data;
  createContactList(data);
  // console.log(PhoneOrgList);
  var html = `
  <div class="d-flex w-100 justify-content-between">
  <div class="sticky-header" id="sticky-header"></div>
        
    </div>
    <ul class="list-group" id="contact-list">`;
  for (var i = 0; i < PhoneOrgList.length; i++) {
    html += `
    <li class="list-group-item" data-org-name="${
      PhoneOrgList[i]
    }" onclick="createFilteredContactList('${PhoneOrgList[i]}', contactList)">
    <p class="first-initial">${getFirstInitial(PhoneOrgList[i])}</p>
          <p class="mb-1">${PhoneOrgList[i]}</p>
        </li>
    `;
  }
  html += `
    </ul>`;
  document.getElementById("contact-list").innerHTML = html;
}
