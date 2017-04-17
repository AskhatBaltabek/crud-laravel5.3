$('.azs-regLog__item').click(function() {
    $(this).find('.azs-form').show(200);
});
$('.azs-chOne').click(function() {
    $(this).find('.azs-chOne__block').show(200);
});
$(document).mouseup(function (e)
{
    var container = $('.azs-form, .azs-chOne__block');

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.hide(200);
    }
});
$(document).ready(function() {
    if ( $('#myCarousel .item').length == 1 && $('.item.active').find('.azs-saleAnews__slider--slide').length <= 4 ) {
        $('#myCarousel .carousel-control').hide();
    }
    if ( $('#myCarousel1 .item').length == 1 && $('.item.active').find('.azs-saleAnews__slider--slide').length <= 2 ) {
        $('#myCarousel1 .carousel-control').hide();
    }
});

$('.azs-link--btn_reviews').click(function() {
    if ( $(this).data('reg') == true ) {
        $('.modal-review').show().find('.azs-regLog__item--form').show();
    } else {
        $('.modal-reg').show().find('.azs-regLog__item--form').show();
    }
});
$('.modal .close').click(function() {
    $('.modal').hide();
});