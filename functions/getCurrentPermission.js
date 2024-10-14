function getCurrentPermissions(userId) {
  return new Promise((resolve, reject) => {
    fetch("./API/getCurrentPermissions.php?userId=" + userId)
      .then((response) => response.json())
      .then((data) => {
        // console.log(data);
        resolve(data);
      });
  });
}
