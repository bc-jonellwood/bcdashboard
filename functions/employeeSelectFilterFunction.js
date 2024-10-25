function filterFunction(inputId, listId) {
  const ulElement = document.getElementById(listId);
  ulElement.classList.remove("hidden");
  // console.log("starting filter");
  var input, filter, list, items, i;

  input = document.getElementById(inputId);
  filter = input.value.toUpperCase();
  list = document.getElementById(listId);
  items = list.getElementsByTagName("li");

  for (i = 0; i < items.length; i++) {
    const item = items[i];
    const txtValue = item.textContent || item.innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      item.style.display = "";
    } else {
      item.style.display = "none";
    }
  }
}
