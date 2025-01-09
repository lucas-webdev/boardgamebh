document.addEventListener("DOMContentLoaded", () => {
  const hamburgerIcon = document.getElementById("menu-toggle");
  const closeMenuIcon = document.getElementById("close-menu");
  const menu = document.getElementById("hamburger-menu");

  hamburgerIcon.addEventListener("click", () => {
    menu.classList.add("flex");
    menu.classList.remove("hidden");
  });
  closeMenuIcon.addEventListener("click", () => {
    menu.classList.add("hidden");
    menu.classList.remove("flex");
  });
});
