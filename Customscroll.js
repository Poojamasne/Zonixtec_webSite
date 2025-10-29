window.addEventListener("load", () => {
  // Check if the user came by clicking the link
  if (sessionStorage.getItem("scrollAfterLoad") === "true") {
    window.scrollBy(0, 700); // scroll down 700px
    sessionStorage.removeItem("scrollAfterLoad"); // reset flag
  }
});

document.getElementById("aboutLink").addEventListener("click", () => {
  sessionStorage.setItem("scrollAfterLoad", "true");
});

window.addEventListener("load", () => {
  // Check if the user came by clicking the link
  if (sessionStorage.getItem("scrollAfterLoad2") === "true") {
    window.scrollBy(0, 2200); // scroll down 700px
    sessionStorage.removeItem("scrollAfterLoad2"); // reset flag
  }
});

document.getElementById("OurJou").addEventListener("click", () => {
  sessionStorage.setItem("scrollAfterLoad2", "true");
});

window.addEventListener("load", () => {
  // Check if the user came by clicking the link
  if (sessionStorage.getItem("scrollAfterLoad3") === "true") {
    window.scrollBy(0, 1200); // scroll down 700px
    sessionStorage.removeItem("scrollAfterLoad3"); // reset flag
  }
});

document.getElementById("OurCore").addEventListener("click", () => {
  sessionStorage.setItem("scrollAfterLoad3", "true");
});
