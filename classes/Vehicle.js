class Vehicle {
  constructor(
    legacyId,
    vehUid,
    vehName,
    vehMaxOccupancy,
    vehOdometer,
    vehUnitNum,
    vehVin,
    vehCargoSpace,
    serviceOdometer,
    isRetired,
    isAvailable
  ) {
    (this.legacyId = legacyId),
      (this.vehUid = vehUid),
      (this.vehName = vehName),
      (this.vehMaxOccupancy = vehMaxOccupancy),
      (this.vehOdometer = vehOdometer),
      (this.vehUnitNum = vehUnitNum),
      (this.vehVin = vehVin),
      (this.vehCargoSpace = vehCargoSpace),
      (this.serviceOdometer = serviceOdometer),
      (this.isRetired = isRetired),
      (this.isAvailable = isAvailable);
  }
  // function to update a single vehicle in the database. Accepts the vehicle UID, the field to update, and the new value.
  updateVehicle(vehUid, field, value) {
    const data = {
      vehUid: vehUid,
      field: field,
      value: value,
    };
    fetch("/API/updateVehicle.php", {
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
