var type = "emp";

function fetchLinkData(type) {
  fetch("./API/getLinkData.php?type=" + type)
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      return data; // console.log(data);
    });
}
