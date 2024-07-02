document.addEventListener('DOMContentLoaded', function () {
    const carousels = document.querySelectorAll('.carousel');

    carousels.forEach(carousel => {
        const inner = carousel.querySelector('.carousel-inner');
        const items = carousel.querySelectorAll('.album-item');
        const prev = carousel.querySelector('.prev');
        const next = carousel.querySelector('.next');
        let currentIndex = 0;

        function updateCarousel() {
            const itemWidth = items[0].clientWidth;
            inner.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
        }

        prev.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
            } else {
                currentIndex = items.length - 4;
            }
            updateCarousel();
        });

        next.addEventListener('click', () => {
            if (currentIndex < items.length - 4) {
                currentIndex++;
            } else {
                currentIndex = 0;
            }
            updateCarousel();
        });

        updateCarousel();
    });

    const slides = document.querySelector('.slides');
    const dots = document.querySelectorAll('.dot');
    let currentIndex = 0;

    function showSlide(index) {
        const slideWidth = slides.clientWidth / 3;
        slides.style.transform = `translateX(-${index * slideWidth}px)`;
        dots.forEach(dot => dot.classList.remove('active'));
        dots[index].classList.add('active');
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentIndex = index;
            showSlide(index);
        });
    });

    function nextSlide() {
        currentIndex = (currentIndex + 1) % dots.length;
        showSlide(currentIndex);
    }

    setInterval(nextSlide, 3000);

    showSlide(currentIndex);
});
