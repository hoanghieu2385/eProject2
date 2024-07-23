document.addEventListener('DOMContentLoaded', function () {
    // Banner slider
    var options = {
        accessibility: true,
        prevNextButtons: true,
        pageDots: true,
        setGallerySize: false,
        autoPlay: 3800,
        wrapAround: true,
        arrowShape: {
            x0: 10,
            x1: 60,
            y1: 50,
            x2: 60,
            y2: 45,
            x3: 15
        }
    };

    var carousel = document.querySelector('.hero-slider');
    var flktyBanner = new Flickity(carousel, options);

    flktyBanner.on('scroll', function () {
        flktyBanner.slides.forEach(function (slide, i) {
            var cellElement = slide.cells[0].element;
            var x = (slide.target + flktyBanner.x) * -1 / 3;
            cellElement.style.backgroundPosition = x + 'px';
        });
    });

    // Log to console to verify initialization
    console.log('Flickity initialized:', flktyBanner);

    // New Release carousel
    var newReleaseCarousel = document.querySelector('.carousel');
    var flkty = new Flickity(newReleaseCarousel, {
        wrapAround: true,
        autoPlay: true,
        groupCells: true,
        cellAlign: 'left',
        contain: true
    });

    // Best Seller carousel
    var bestsellersCarousel = document.querySelectorAll('.carousel')[1];
    var flktyBestsellers = new Flickity(bestsellersCarousel, {
        wrapAround: true,
        autoPlay: true,
        groupCells: true,
        cellAlign: 'left',
        contain: true
    });
});