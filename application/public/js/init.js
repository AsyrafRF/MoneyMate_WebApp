document.addEventListener("DOMContentLoaded", function() {
    new Swiper(".heroSwiper", {
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
        speed: 800,
        effect: "slide", // bisa juga 'fade' atau 'creative'
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
});