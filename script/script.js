

document.addEventListener("DOMContentLoaded", function(e){
    slideMenu();
    mainSlide();
    successTab();
})

const successTab = () => {
    $('.success-tag-list .tag-btn').click(function(){
        $('.success-tag-list .tag-btn').removeClass('active');
        $(this).addClass('active');
        $('.tab-content-list > li').removeClass('active');
        $('.tab-content-list > li').eq($(this).index()).addClass('active');
    })
}

const mainSlide = () => {
    // 총 7개의 지역에서 의뢰인을 돕고 있습니다.
    var swiper = new Swiper(".main .section5 .mySwiper", {
        slidesPerView: 2.5,
        spaceBetween: 30,
        loopedSlides: 7,
        loop:true, 
        centeredSlides: true,
        observer: true,
        observeParents: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        navigation: {
          nextEl: ".main .section3 .slide-wrap .btn-wrap .pn-btn.next-btn",
          prevEl: ".main .section3 .slide-wrap .btn-wrap .pn-btn.prev-btn",
        },
        breakpoints: {
            0: {
                slidesPerView: 1.2,
                spaceBetween: 10,
            },
            650: {
              slidesPerView: 1.2,
              spaceBetween: 10,
            },
            950: {
              slidesPerView: 2,
              spaceBetween: 10,
            },
            1250: {
              slidesPerView: 2,
              spaceBetween: 10,
            },
            2500: {
                slidesPerView: 2.5,
                spaceBetween: 30,
            },
          },
    });

    // 굿플랜의 업무 사례
    var swiper = new Swiper(".main .section4 .mySwiper", {
        slidesPerView: 3,
        spaceBetween: 20,
        loop:true, 
        centeredSlides: true,
        observer: true,
        observeParents: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        navigation: {
          nextEl: ".main .section3 .slide-wrap .btn-wrap .pn-btn.next-btn",
          prevEl: ".main .section3 .slide-wrap .btn-wrap .pn-btn.prev-btn",
        },
        breakpoints: {
            0: {
                slidesPerView: 1.2,
                spaceBetween: 10,
            },
            650: {
              slidesPerView: 1.2,
              spaceBetween: 10,
            },
            950: {
              slidesPerView: 2,
              spaceBetween: 10,
            },
            1250: {
              slidesPerView: 3,
              spaceBetween: 10,
            },
            2500: {
                slidesPerView: 3,
                spaceBetween: 10,
            },
          },
    });

    
    // 분야별 전담 시스템으로 대응하는 주요 업무
    var swiper = new Swiper(".main .section3 .mySwiper", {
        slidesPerView: 3,
        spaceBetween: 20,
        loop:true, 
        centeredSlides: true,
        observer: true,
        observeParents: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        navigation: {
          nextEl: ".main .section3 .slide-wrap .btn-wrap .pn-btn.next-btn",
          prevEl: ".main .section3 .slide-wrap .btn-wrap .pn-btn.prev-btn",
        },
        breakpoints: {
            0: {
                slidesPerView: 1.2,
                spaceBetween: 10,
            },
            650: {
              slidesPerView: 1.2,
              spaceBetween: 10,
            },
            950: {
              slidesPerView: 2.5,
              spaceBetween: 10,
            },
            1250: {
              slidesPerView: 3,
              spaceBetween: 10,
            },
            2500: {
                slidesPerView: 3,
                spaceBetween: 10,
            },
          },
    });
}

const slideMenu = () => {
    $('header .menu-btn').click(function(){
        $('.slide-menu').addClass('show');
    })

    $('.slide-menu .btn-div .close-btn').click(function(){
        $('.slide-menu').removeClass('show');
    })
}

