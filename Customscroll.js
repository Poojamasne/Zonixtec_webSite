// When user clicks the Mission & Vision link, set a flag
document.addEventListener("DOMContentLoaded", () => {
  const link = document.getElementById("aboutLink");
  if (link) {
    link.addEventListener("click", () => {
      sessionStorage.setItem("scrollAfterLoad", "true");
    });
  }
});

// On aboutus.html, check the flag and scroll down if needed
window.addEventListener("load", () => {
  if (sessionStorage.getItem("scrollAfterLoad") === "true") {
    window.scrollBy({
      top: 700, // scroll down 700px
      behavior: "smooth", // optional smooth scroll
    });
    sessionStorage.removeItem("scrollAfterLoad"); // reset flag
  }
});
