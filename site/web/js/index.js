$(document).ready(function () {
    $('.btn-sidenav-toggle').click(function () {
        if ($('.side-nav').hasClass('open')) {
            $('.side-nav').removeClass('open');
        } else {
            $('.side-nav').addClass('open');
        }
    });
});