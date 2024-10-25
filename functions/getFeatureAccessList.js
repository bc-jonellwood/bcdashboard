function removeUnderScore(string) {
  return string.replace(/_/g, " ");
}

function getFeatureAccessList() {
  fetch("./API/getFeaturesAccessList.php")
    .then((response) => response.json())
    .then((data) => {
      // console.log(data);
      var html = "";
      html += `
        <form action="" method="POST" id="featureAccessForm">
            
            `;
      for (var i = 0; i < data.length; i++) {
        html += `
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value=${
                      data[i].id
                    } id="flexCheckDefault">
                    <label class="form-check-label capitalize" for="flexCheckDefault">
                        ${removeUnderScore(data[i].sNameAndAccess)} 
                    </label>
                    </div>
                `;
      }
      html += `
        <button type="button" class="btn btn-primary" onclick="validateAndSubmitForm()">Submit</button>
        </form>
      `;
      document.getElementById("featureAccessList").innerHTML = html;
    });
}
