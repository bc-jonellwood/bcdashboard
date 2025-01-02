class User {
  constructor(
    id,
    sUserName,
    sHashedPass,
    sEmployeeNumber,
    sFirstName,
    sPreferredName,
    sMiddleName,
    sLastName,
    dtDateOfBirth,
    iDepartmentNumber,
    sEmail,
    sMainPhoneNumber,
    sMainPhoneNumberLabel,
    sSecondaryPhoneNumber,
    sSecondaryPhoneNumberLabel,
    bIsActive,
    bIsLDAP,
    bIsAdmin,
    bHideBirthday,
    dtLastLogin,
    dtLastSystemUpdate,
    dtStartDate,
    dtSeparationDate,
    iStatus,
    bShowStatus,
    sJobTitle,
    sADStatus
  ) {
    this.id,
      this.sUserName,
      this.sHashedPass,
      this.sEmployeeNumber,
      this.sFirstName,
      this.sPreferredName,
      this.sMiddleName,
      this.sLastName,
      this.dtDateOfBirth,
      this.iDepartmentNumber,
      this.sEmail,
      this.sMainPhoneNumber,
      this.sMainPhoneNumberLabel,
      this.sSecondaryPhoneNumber,
      this.sSecondaryPhoneNumberLabel,
      this.bIsActive,
      this.bIsLDAP,
      this.bIsAdmin,
      this.bHideBirthday,
      this.dtLastLogin,
      this.dtLastSystemUpdate,
      this.dtStartDate,
      this.dtSeparationDate,
      this.iStatus,
      this.bShowStatus,
      this.sJobTitle,
      this.sADStatus;
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
