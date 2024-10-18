function renderRequestLocationDataSelectOptions(id) {
  var data = requestLocationData();
  //   console.log(data);
  //   console.log(id);
  var target = document.getElementById(id);
  //   console.log(target);

  for (var i = 0; i < data.length; i++) {
    var option = document.createElement("option");
    option.text = data[i].name;
    option.value = data[i].name;
    target.add(option);
  }
}
