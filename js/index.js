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
    var flkty = new Flickity(newReleaseCarousel, {
        wrapAround: true,
        autoPlay: true,
        groupCells: true,
        cellAlign: 'left',
        contain: true
    });

    // Best Seller
    var flktyBestsellers = new Flickity(bestsellersCarousel, {
        wrapAround: true,
        autoPlay: true,
        groupCells: true,
        cellAlign: 'left',
        contain: true
    });
});
