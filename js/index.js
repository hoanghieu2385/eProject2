document.addEventListener('DOMContentLoaded', function () {
    // Banner slider
    let bannerSlideIndex = 0;
    const bannerSlides = document.querySelectorAll('.banner-slider .slides img');
    const bannerDots = document.querySelectorAll('.banner-slider .dot');

    function showBannerSlide(index) {
        bannerSlides.forEach(slide => slide.style.display = 'none');
        bannerDots.forEach(dot => dot.classList.remove('active'));

        bannerSlides[index].style.display = 'block';
        bannerDots[index].classList.add('active');
    }

    function nextBannerSlide() {
        bannerSlideIndex = (bannerSlideIndex + 1) % bannerSlides.length;
        showBannerSlide(bannerSlideIndex);
    }

    setInterval(nextBannerSlide, 5000);

    bannerDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            bannerSlideIndex = index;
            showBannerSlide(bannerSlideIndex);
        });
    });

    showBannerSlide(bannerSlideIndex);

    // New Release carousel
    const newReleaseCarousel = document.querySelector('.new-release .carousel-inner');
    const newReleaseItems = newReleaseCarousel.querySelectorAll('.album-item');
    const newReleasePrevBtn = document.querySelector('.new-release .prev');
    const newReleaseNextBtn = document.querySelector('.new-release .next');
    let newReleaseCurrentIndex = 0;

    function showNewReleaseItems() {
        newReleaseItems.forEach((item, index) => {
            if (index >= newReleaseCurrentIndex && index < newReleaseCurrentIndex + 4) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // function showNewReleaseItems() {
    //     newReleaseItems.forEach((item, index) => {
    //         item.style.transform = `translateX(${(index - newReleaseCurrentIndex) * 100}%)`;
    //     });
    // }

    function nextNewReleaseSlide() {
        newReleaseCurrentIndex = (newReleaseCurrentIndex + 1) % newReleaseItems.length;
        if (newReleaseCurrentIndex + 4 > newReleaseItems.length) {
            newReleaseCurrentIndex = 0;
        }
        showNewReleaseItems();
    }

    function prevNewReleaseSlide() {
        newReleaseCurrentIndex = (newReleaseCurrentIndex - 1 + newReleaseItems.length) % newReleaseItems.length;
        if (newReleaseCurrentIndex < 0) {
            newReleaseCurrentIndex = newReleaseItems.length - 4;
        }
        showNewReleaseItems();
    }

    newReleaseNextBtn.addEventListener('click', nextNewReleaseSlide);
    newReleasePrevBtn.addEventListener('click', prevNewReleaseSlide);

    setInterval(nextNewReleaseSlide, 5000);

    showNewReleaseItems();

    
});