class Driver {
  constructor(
    id,
    sBcgiId,
    sEmployeeNumber,
    sUserId,
    dtDlExpires,
    dtFleetTestPassed,
    dtFuelCardTestPassed,
    dtAcknowledge,
    dlFront,
    dlBack,
    sNotes
  ) {
    (this.id = id),
      (this.sBcgiId = sBcgiId),
      (this.sEmployeeNumber = sEmployeeNumber),
      (this.sUserId = sUserId),
      (this.dtDlExpires = dtDlExpires),
      (this.dtFleetTestPassed = dtFleetTestPassed),
      (this.dtFuelCardTestPassed = dtFuelCardTestPassed),
      (this.dtAcknowledge = dtAcknowledge),
      (this.dlFront = dlFront),
      (this.dlBack = dlBack),
      (this.sNotes = sNotes);
  }

  updateDriver(id, field, val) {
    const data = {
      id: id,
      field: field,
      val: val,
    };
    fetch("/API/updateDriver.php", {
      method: "POST",
      body: JSON.stringify(data),
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Success:", data);
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }
}
