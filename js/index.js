document.addEventListener('DOMContentLoaded', function () {
    // Banner slider
    var options = {
        accessibility: true,
        prevNextButtons: true,
        pageDots: true,
        setGallerySize: false,
        wrapAround: true,
        autoPlay: true,
        arrowShape: {
            x0: 10,
            x1: 60,
            y1: 50,
            x2: 60,
            y2: 45,
            x3: 15
        }
    };

    var carousel = document.querySelector('[data-carousel]');
    var slides = document.getElementsByClassName('carousel-cell');
    var flktyBanner = new Flickity(carousel, options);

    flktyBanner.on('scroll', function () {
        flktyBanner.slides.forEach(function (slide, i) {
            var image = slides[i];
            var x = (slide.target + flktyBanner.x) * -1 / 3;
            image.style.backgroundPosition = x + 'px';
        });
    });

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
