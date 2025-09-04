import "./bootstrap.js";
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import "./styles/app.css";

console.log("This log comes from assets/app.js - welcome to AssetMapper! 🎉");

// Carrousel horizontal
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
    if (!document.getElementById("rating-stars")) return;

    const stars = document.querySelectorAll("#rating-stars svg");
    let selectedRating = 0;
    const ratingInput = document.querySelector('input[name="rating"]');

    function fillStars(rating) {
        stars.forEach((star) => {
            const starValue = parseInt(star.getAttribute("data-star"));
            if (starValue <= rating) {
                star.classList.add("text-orange-500");
                star.classList.remove("text-gray-400");
            } else {
                star.classList.add("text-gray-400");
                star.classList.remove("text-orange-500");
            }
        });
    }

    stars.forEach((star) => {
        star.addEventListener("mouseenter", () => {
            fillStars(parseInt(star.getAttribute("data-star")));
        });
        star.addEventListener("mouseleave", () => {
            fillStars(selectedRating);
        });
        star.addEventListener("click", () => {
            selectedRating = parseInt(star.getAttribute("data-star"));
            fillStars(selectedRating);
            if (ratingInput) {
                ratingInput.value = selectedRating;
            }
        });
    });

    fillStars(selectedRating);
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

// favoris
document.querySelectorAll(".favori-form").forEach((form) => {
    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Empêche le rechargement

        const mangaId = this.dataset.mangaId;
        const url = `/favori/add/${mangaId}`;
        const button = this.querySelector(".btn-favori");

        fetch(url, {
            method: "POST",
            headers: { "X-Requested-With": "XMLHttpRequest" },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    button.classList.add("active");
                } else {
                    alert(data.message || "Erreur lors de l'ajout aux favoris");
                }
            })
            .catch(() => alert("Erreur réseau"));
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const filterToggle = document.getElementById('filter-toggle');
    const filterDropdown = document.getElementById('filter-dropdown');

    filterToggle.addEventListener('click', function(event) {
        event.stopPropagation();
        filterDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', () => {
        filterDropdown.classList.add('hidden');
    });

    filterDropdown.addEventListener('click', e => e.stopPropagation());
});
