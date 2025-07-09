const marqueefyList = Array.prototype.slice.call(document.querySelectorAll('.marqueefy'))
const marqueefyInstances = marqueefyList.map(m => {
    return new marqueefy.Marqueefy(m, { speed: 100 })
})

document.addEventListener('DOMContentLoaded', function () {
    var ele = $('.customers-splide').length;
    if(ele){
        var bannerSplide = new Splide('.banner-splide', {
            type: 'slide',
            perPage: 1,
            perMove: 1,
            arrows: false,
        });
        bannerSplide.mount();
        
        var trendingSplide = new Splide('.trending-splide', {
            type: 'slide',
            perPage: 3,
            perMove: 1,
            pagination: false,
            gap: 30,
            breakpoints: {
                991: {
                    perPage: 2,
                },
                575: {
                    perPage: 1,
                },
            },
        });
        trendingSplide.mount();
        
        
        var customersSplide = new Splide('.customers-splide', {
            type: 'loop',
            perPage: 2,
            perMove: 1,
            pagination: false,
            gap: 30,
            breakpoints: {
                991: {
                    perPage: 1,
                },
            },
        });
        customersSplide.mount();
    }
});


