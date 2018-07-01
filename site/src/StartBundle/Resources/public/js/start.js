$(document).ready(function(){

    $('.btn-start-next').click(function(){
        //let id = $(this).parent().data('id');
        //let nextId = $(this).parent().next().data('id');

        var elem = $(this);

        var timeout = $(this).parent().data('timeout');
        var timeoutHtml = $(this).parent().data('timeout');

        var timeout = 3;
        var timeoutHtml = 3;


        $('.start-training-timeout').html(timeoutHtml);

        setTimeout(function(){
            var setInterval1 = setInterval(function(){

                if (timeoutHtml == timeout){
                    $('.start-training-timeout').addClass('active');
                    $(elem).parent().addClass('start-training-hidden');
                }

                if (timeoutHtml == 0){
                    clearInterval(setInterval1);
                    $(elem).parent().next().removeClass('start-training-hidden');
                    $('.start-training-timeout').removeClass('active');
                }

                $('.start-training-timeout').html(timeoutHtml);
                timeoutHtml--;
            }
            , 1000);
        }, timeout);

    });
});