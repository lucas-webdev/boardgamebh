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

const carousel = document.getElementById("carousel");
const prevBtn = document.getElementById("prev");
const nextBtn = document.getElementById("next");

let currentIndex = 0;
const images = carousel.children;
const totalImages = images.length;

// Número de imagens visíveis
const imagesPerSlide = window.matchMedia("(min-width: 768px)").matches ? 2 : 1;

// Atualiza o número de imagens visíveis quando a tela redimensionar
window.addEventListener("resize", () => {
  const newImagesPerSlide = window.matchMedia("(min-width: 768px)").matches
    ? 2
    : 1;
  if (newImagesPerSlide !== imagesPerSlide) {
    currentIndex = 0;
    updateCarousel();
  }
});

function updateCarousel() {
  const gap = 12; // Espaço entre os itens em pixels
  const slideWidth = images[0].clientWidth + gap;
  const offset = currentIndex * slideWidth * imagesPerSlide;
  carousel.style.transform = `translateX(-${offset}px)`;
}

nextBtn.addEventListener("click", () => {
  currentIndex = (currentIndex + 1) % Math.ceil(totalImages / imagesPerSlide);
  updateCarousel();
});

prevBtn.addEventListener("click", () => {
  currentIndex =
    (currentIndex - 1 + Math.ceil(totalImages / imagesPerSlide)) %
    Math.ceil(totalImages / imagesPerSlide);
  updateCarousel();
});
