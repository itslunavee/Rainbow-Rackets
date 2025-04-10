document.addEventListener('DOMContentLoaded', function() {

// Hamburger menu functionality
const hamburger = document.getElementById("mobile-menu-btn");
const navLinks = document.getElementById("admin-nav");

if (hamburger && navLinks) {
    hamburger.addEventListener("click", function () {
        navLinks.classList.toggle("active");
    });

    navLinks.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", function () {
            if (window.innerWidth <= 768) {
                navLinks.classList.remove("active");
            }
        });
    });
  }
})