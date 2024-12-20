// fetch data from API. API will get userID from the cookie and return user data
// the user ID is stored in the cookie rememberme with a key of "userID" that value needs to be sent to the API with a GET method

function getCookieValue(cookieName) {
  const cookies = document.cookie.split("; ");
  const cookie = cookies.find((c) => c.startsWith(`${cookieName}=`));
  return cookie ? decodeURIComponent(cookie.split("=")[1]) : null;
}

const userIDCookie = getCookieValue("bcdash_user");

if (userIDCookie) {
  const cookieData = JSON.parse(userIDCookie);
  const userID = cookieData.userID;

  if (userID) {
    const endpoint = `/API/getSingleUserById.php?id=${userID}`;

    fetch(endpoint, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error. Status: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        console.log("User Data Returned: ", data);
        localStorage.setItem("bcdash-userData", JSON.stringify(data));
      })
      .catch((error) => {
        console.error("Error fetching user data: ", error);
      });
  } else {
    console.error("No user ID found in cookie data");
  }
} else {
  console.error("No rememberme cookie found");
}
