/**
 * Generates a GUID (Globally Unique Identifier).
 * @returns {string} A GUID in the format xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
 */
function generateGUID() {
  try {
    // Generate a random GUID
    const randomPart = () =>
      Math.floor((1 + Math.random()) * 0x10000)
        .toString(16)
        .substring(1);
    const guid = `${randomPart()}${randomPart()}-${randomPart()}-${randomPart()}-${randomPart()}-${randomPart()}${randomPart()}${randomPart()}`;

    return guid.toUpperCase();
  } catch (error) {
    console.error("An error occurred while generating the GUID:", error);
    return null; // Return null in case of an error
  }
}
