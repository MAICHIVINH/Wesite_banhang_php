document.addEventListener('DOMContentLoaded', function () {
    function setupCarouselControl(carouselId) {
        const carousel = document.getElementById(carouselId);
        const prevBtn = carousel.querySelector('.carousel-control-prev');
        const nextBtn = carousel.querySelector('.carousel-control-next');
        const items = carousel.querySelectorAll('.carousel-item');
        const totalSlides = items.length;

        const updateButtons = () => {
            const activeIndex = Array.from(items).findIndex(item => item.classList.contains('active'));

            // Disable nút Trước
            if (activeIndex === 0) {
                prevBtn.classList.add('disabled');
                prevBtn.setAttribute('disabled', 'disabled');
            } else {
                prevBtn.classList.remove('disabled');
                prevBtn.removeAttribute('disabled');
            }

            // Disable nút Tiếp
            if (activeIndex === totalSlides - 1) {
                nextBtn.classList.add('disabled');
                nextBtn.setAttribute('disabled', 'disabled');
            } else {
                nextBtn.classList.remove('disabled');
                nextBtn.removeAttribute('disabled');
            }
        };

        updateButtons();

        carousel.addEventListener('slid.bs.carousel', updateButtons);
    }
    setupCarouselControl('featuredCarousel');
    setupCarouselControl('saleCarousel');
});


