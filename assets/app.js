import "./bootstrap.js";
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import "./styles/app.css";

console.log("This log comes from assets/app.js - welcome to AssetMapper! 🎉");

document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("scroll-container");
    const btnLeft = document.getElementById("scroll-left");
    const btnRight = document.getElementById("scroll-right");
    const scrollAmount = 300; // Nombre de pixels à scroller

    btnLeft.addEventListener("click", () => {
        container.scrollBy({ left: -scrollAmount, behavior: "smooth" });
    });

    btnRight.addEventListener("click", () => {
        container.scrollBy({ left: scrollAmount, behavior: "smooth" });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("scroll-container-classic");
    const btnLeft = document.getElementById("scroll-left-classic");
    const btnRight = document.getElementById("scroll-right-classic");
    const scrollAmount = 300; // Nombre de pixels à scroller

    btnLeft.addEventListener("click", () => {
        container.scrollBy({ left: -scrollAmount, behavior: "smooth" });
    });

    btnRight.addEventListener("click", () => {
        container.scrollBy({ left: scrollAmount, behavior: "smooth" });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("scroll-container-new");
    const btnLeft = document.getElementById("scroll-left-new");
    const btnRight = document.getElementById("scroll-right-new");
    const scrollAmount = 300; // Nombre de pixels à scroller

    btnLeft.addEventListener("click", () => {
        container.scrollBy({ left: -scrollAmount, behavior: "smooth" });
    });

    btnRight.addEventListener("click", () => {
        container.scrollBy({ left: scrollAmount, behavior: "smooth" });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("scroll-container-md");
    const btnLeft = document.getElementById("scroll-left-md");
    const btnRight = document.getElementById("scroll-right-md");
    const scrollAmount = 300; // Nombre de pixels à scroller

    btnLeft.addEventListener("click", () => {
        container.scrollBy({ left: -scrollAmount, behavior: "smooth" });
    });

    btnRight.addEventListener("click", () => {
        container.scrollBy({ left: scrollAmount, behavior: "smooth" });
    });
});

// Notation
document.addEventListener("DOMContentLoaded", () => {
    const stars = document.querySelectorAll("#rating-stars svg");
    const ratingInput = document.getElementById("rating-input");
    let currentRating = 0;

    const setStars = (rating) => {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add("text-yellow-400");
                star.classList.remove("text-gray-400");
            } else {
                star.classList.add("text-gray-400");
                star.classList.remove("text-yellow-400");
            }
        });
    };

    stars.forEach((star) => {
        star.addEventListener("mouseenter", () => {
            const hoverValue = parseInt(star.getAttribute("data-star"));
            setStars(hoverValue);
        });

        star.addEventListener("mouseleave", () => {
            setStars(currentRating);
        });

        star.addEventListener("click", () => {
            currentRating = parseInt(star.getAttribute("data-star"));
            ratingInput.value = currentRating;
            setStars(currentRating);
        });
    });

    // Si tu veux, initialise depuis la valeur existante dans ratingInput
    if (ratingInput.value) {
        currentRating = parseInt(ratingInput.value);
        setStars(currentRating);
    }
});

const input = document.querySelector('label input[data-model="query"]');
const label = input.closest("label");

input.addEventListener("input", () => {
    if (input.value.trim() !== "") {
        label.classList.add("border-indigo-500", "shadow-indigo-300");
    } else {
        label.classList.remove("border-indigo-500", "shadow-indigo-300");
    }
});
