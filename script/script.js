

document.addEventListener("DOMContentLoaded", function(e){
    slideMenu();
})

const slideMenu = () => {
    $('header .menu-btn').click(function(){
        $('.slide-menu').addClass('show');
    })

    $('.slide-menu .btn-div .close-btn').click(function(){
        $('.slide-menu').removeClass('show');
    })
}

