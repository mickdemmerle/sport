$(document).ready(function () {
    $('.js-edit-link').click(function(){
        window.location = $(this).data('url');
    });
});