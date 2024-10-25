function addBlankSelectOption(id, item) {
  // console.log(id, item);
  const selectElement = document.getElementById(id);
  selectElement.innerHTML += `
<option selected>Select an ${item}</option>
`;
}
