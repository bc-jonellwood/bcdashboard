function getInitials(name) {
  return name
    .split(" ")
    .slice(0, 2) // Take only the first two name parts
    .map((n) => n[0])
    .join("")
    .toUpperCase();
}
