$(document).ready(function(){
    $('#status').change(function() {
        if($(this).val() === 'deceased') {
            $('#death-date-field').show();
        }else{
            $('#death-date-field').hide();
        }
    });
});

const myCarouselElement = document.querySelector('#myCarousel')

const carousel = new bootstrap.Carousel(myCarouselElement, {
    interval: 2000,
    touch: false
})