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




 document.addEventListener("DOMContentLoaded", function () {
   const dropdownToggles = document.querySelectorAll(".dropdown-toggle");

   dropdownToggles.forEach((toggle) => {
     toggle.addEventListener("click", function (e) {
       if (window.innerWidth <= 768) {
         e.preventDefault();
         const dropdown = this.parentElement;
         dropdown.classList.toggle("active");

         // Close other dropdowns
         document.querySelectorAll(".dropdown").forEach((otherDropdown) => {
           if (otherDropdown !== dropdown) {
             otherDropdown.classList.remove("active");
           }
         });
       }
     });
   });

   // Close dropdowns when clicking outside
   document.addEventListener("click", function (e) {
     if (
       !e.target.closest(".dropdown") &&
       !e.target.closest(".mobile-menu-btn")
     ) {
       document.querySelectorAll(".dropdown").forEach((dropdown) => {
         dropdown.classList.remove("active");
       });
     }
   });

   // Newsletter functionality
   const btn = document.getElementById("newsletter-btn");
   const emailInput = document.getElementById("newsletter-email");
   const thankyou = document.getElementById("newsletter-thankyou");

   if (btn && emailInput && thankyou) {
     btn.addEventListener("click", function () {
       if (emailInput.value && /\S+@\S+\.\S+/.test(emailInput.value)) {
         thankyou.style.display = "block";
         setTimeout(() => {
           thankyou.style.display = "none";
         }, 3000);
         emailInput.value = "";
       } else {
         emailInput.focus();
         emailInput.style.borderColor = "#e74c3c";
         setTimeout(() => {
           emailInput.style.borderColor = "";
         }, 1500);
       }
     });
   }

   // Show image placeholder if image fails to load
   const image = document.querySelector(".services-image img");
   const placeholder = document.getElementById("image-placeholder");

   if (image && image.naturalWidth === 0) {
     image.style.display = "none";
     placeholder.style.display = "flex";
   }
 });